<?php


namespace App\Services;


use App\Enum\PaymentMethod;
use App\Models\OrderProduct;
use App\Repositories\OrderRepositoryInterface;

class OrderService
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAllOrders() {
        return $this->orderRepository->all();
    }

    // Business logic to find a user by ID
    public function getUserById($id)
    {
        return $this->orderRepository->find($id);
    }

    // Business logic to create a new user
    public function createOrder($cart)
    {
        // Add additional business logic, such as validation, here
        $order_data = [
            'order_total' => $cart['amount']['order_total'],
            'currency' => $cart['amount']['currency'],
            'order_date_time' => date('Y-m-d H:i:s'),
            'order_status' => 'Processing',
            'payment_reference_code' => $cart['payment_reference_code'],
            'payment_method' => PaymentMethod::STRIPE
        ];

        $prepare_response = [
            'status' => 'error',
            'message' => '',
            'data' => []
        ];

        $order = $this->orderRepository->create($order_data);
        if ($order) {
            $order_id = $order['id'];
            $prepare_response['data']['order_id'] = $order_id;

            $cart_products = $cart['products'] ?? [];
            if (!empty($cart_products)) {
                $prepared_products = [];
                foreach ($cart_products as $cart_product) {
                    $order_product = [
                        'product_id' => $cart_product['id'],
                        'product_name' => $cart_product['name'],
                        'product_price' => $cart_product['price'],
                        'product_quantity' => $cart_product['quantity'],
                    ];
                    $prepared_products[] = new OrderProduct($order_product);
                }
                // Save all comments related to the post
                $order_products = $order->order_products()->saveMany($prepared_products);
                if (empty($order_products)) {
                    // TODO write error log here
                }
            }
        }

        return $prepare_response;
    }

    // Business logic to update a user
    public function updateUser($id, array $data)
    {
        // Additional business logic, such as checking permissions
        return $this->orderRepository->update($id, $data);
    }

    // Business logic to delete a user
    public function deleteUser($id)
    {
        return $this->orderRepository->delete($id);
    }
}
