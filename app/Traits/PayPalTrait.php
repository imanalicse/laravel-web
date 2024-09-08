<?php
namespace App\Traits;

use App\Enum\PaymentMode;
use Illuminate\Support\Facades\Http;

trait PayPalTrait {

    public function getPayPalTransactionMode(): string {
       return 'TEST';
    }

    public function getPayPalBaseUrl() : string {
        $transaction_mode = $this->getPayPalTransactionMode();
        $paypal_base_url = 'https://api-m.paypal.com';
        if ($transaction_mode === PaymentMode::TEST) {
            $paypal_base_url = 'https://api-m.sandbox.paypal.com';
        }
        return $paypal_base_url;
    }

    public function getPayPalClientId() {
        $transaction_mode = $this->getPayPalTransactionMode();
        return env('PAYPAL_CLIENT_ID_'. $transaction_mode);
    }

    public function getPayPalSecretKey() {
        $transaction_mode = $this->getPayPalTransactionMode();
        return env('PAYPAL_SECRET_KEY_'. $transaction_mode);
    }

    public function getPayPalAuthorizationCode() : string {
        $transaction_mode = $this->getPayPalTransactionMode();
        $paypal_secret_key = env('PAYPAL_SECRET_KEY_'. $transaction_mode);
        $auth_code = $this->getPayPalClientId() . ':' . $paypal_secret_key;
        return base64_encode($auth_code);
    }

    public function getPayPalBasicHeader($authorizationCode): array {
        return [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '. $authorizationCode,
        ];
    }

    public function getPayPalHeader($access_token): array {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '. $access_token,
        ];
    }

    public function generatePapPalAccessToken() {
        $access_token = '';
        try {
            $request_data = [];
            $request_data['grant_type'] = 'client_credentials';
            $url = $this->getPayPalBaseUrl() . '/v1/oauth2/token';
            $paypal_client_id = $this->getPayPalClientId();
            $paypal_secret_key = $this->getPayPalSecretKey();
            $response = Http::withBasicAuth($paypal_client_id, $paypal_secret_key)->asForm()->post($url, $request_data);
            $response_data = $response->json();
            if ($response->successful()) {
                return $response_data['access_token'] ?? '';
            }

            $this->customLog('get_token_papal_error: ' . $response->body(), 'pay_pal_error', 'pay_pal');
        }
        catch (\Exception $exception) {
            $error_message = $exception->getMessage();
            $this->customLog(  'Error in payPal token request: ' . $error_message, 'pay_pal_error', 'pay_pal');
        }
        return $access_token;
    }

    public function payPalRequestData() {
        try {
//            $order_code_id = $this->getComponent('CommonFunction')->saveAndGetNewPaymentOrderCode(PaymentMethod::PAY_PAL);
//            if (empty($order_code_id)) {
//                die();
//            }

            $cart = $this->cartGet();
            // $currency = $this->getCurrencyFromCart($cart);
            $currency = $cart['amount']['currency'];
            $amount = $cart['amount']['order_total'];
            $service_charge_amount = 0;

            $item_total_value = 0;
            $items = [];
            foreach ($cart['products'] as $product) {
                $product_attributes = $product['attributes'] ?? [];
                $item_name_arr = [];
                $item_name_arr[] = $product['name'];
                if (!empty($product_attributes)) {
                    foreach ($product_attributes as $attr) {
                        if (isset($attr['visibility']) && $attr['visibility']) {
                            if ($attr['price'] == 0 || $attr['price'] == '') {
                                $item_name_arr[] = $attr['value'];
                            }
                            else {
                                $attr_value = $attr['value'];
                                if (isset($attr['quantity']) && $attr['quantity'] > 1) {
                                    $attr_value .= ' X ' . $attr['quantity'];
                                }
                                $item_name_arr[] = $attr_value;
                            }
                        }
                    }
                }

                $item_name = '';
                if (!empty($item_name_arr)) {
                    $item_name = implode(', ', $item_name_arr);
                }
                $item_name = substr($item_name, 0, 126);
                $quantity = $product['quantity'];
                $item_total_value += $quantity * $product['price'];
                $item = [
                    "name" => $item_name,
                    "quantity" => $quantity,
                    "unit_amount" => [
                        "currency_code" => $currency,
                        "value" => $this->decimalPrice($product['price']),
                    ],
                ];
                $items[] = $item;
            }

            $shipping_amount = $cart['shipping']['amount'] ?? 0;
            $discount = $cart['coupon']['amount'] ?? 0;
            $discount = abs($discount);

            $order_code_id = uniqid();
            $reference_id = $order_code_id;

            $request_data = [];
            $request_data['intent'] = 'CAPTURE';
            $request_data['purchase_units'] = [
                [
                    "reference_id" => $order_code_id,
                    "invoice_id" => $order_code_id,
                    'items' => $items,
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => $this->decimalPrice($amount),
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => $currency,
                                'value' => $this->decimalPrice($item_total_value),
                            ],
                            'shipping' => [
                                'currency_code' => $currency,
                                'value' => $this->decimalPrice($shipping_amount),
                            ],
                            'handling' => [
                                'currency_code' => $currency,
                                'value' => $this->decimalPrice($service_charge_amount),
                            ],
                            "discount" => [
                                "currency_code" => $currency,
                                "value"=> $this->decimalPrice($discount)
                            ]
                        ]
                    ]
                ]
            ];

            $request_data['payment_source'] = [
                'paypal' => [
                    'experience_context' => [
                        'brand_name' => 'RGS',
                        'shipping_preference' => 'GET_FROM_FILE', // Default - GET_FROM_FILE, NO_SHIPPING, SET_PROVIDED_ADDRESS
                        'landing_page' => 'NO_PREFERENCE', // NO_PREFERENCE - Default, LOGIN, GUEST_CHECKOUT
                        'user_action' => 'PAY_NOW',
                        'payment_method_preference' => "UNRESTRICTED", // default - UNRESTRICTED, IMMEDIATE_PAYMENT_REQUIRED
                        // 'locale' => "en-US",
                        // 'return_url' => $this->generateUrl('checkout'),
                        // 'cancel_url' => $this->generateUrl('checkout'),
                    ]
                ]
            ];

//            $shipping = $this->getPayPalShipping($cart);
//            if (!empty($shipping)) {
//                $request_data['purchase_units'][0]['shipping'] = $shipping;
//            }

            return $request_data;
        }
        catch (\Exception $exception) {
            $this->customLog("Error in payPalRequestData :". $exception->getMessage() . " ->cart: ". $this->json_encode($cart), 'pay_pal_error', PaymentMethod::PAY_PAL);
        }
    }

    public function getPayPalShipping($cart) : array {

        $address = $cart['delivery'];
        $admin_area_2 = $address['city'];
        $countryCode = $address['country']['iso_code_2'] ?? '';

        $full_name = $address['first_name'] . ' ' . $address['last_name'];
        $address_line_1 = $address['address_line_1'];
        $address_line_2 = $address['address_line_2'] ?? '';
        $admin_area_1 = $address['state'];
        $postal_code = $address['postcode'];

        if (empty($full_name) || empty($address_line_1) || empty($admin_area_2) || empty($admin_area_1) || empty($postal_code) || empty($countryCode)) {
            return [];
        }


        $shipping_address =  [
            "address_line_1" => $address_line_1,
            "address_line_2" => $address_line_2,
            "admin_area_2" => $admin_area_2,
            "admin_area_1" => $admin_area_1,
            "postal_code" => $postal_code,
            "country_code" => $countryCode
        ];

        $shipping_item = [
            'type' => 'SHIPPING', //SHIPPING, PICKUP_IN_PERSON
            'name' => [
                'full_name' => $full_name
            ],
            'address' => $shipping_address
        ];
        return $shipping_item;
    }
}
