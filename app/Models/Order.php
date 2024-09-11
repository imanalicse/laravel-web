<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $uuid
 * @property string $order_total
 * @property string $service_amount
 * @property string $shipping_amount
 * @property string $tax_amount
 * @property string $coupon_amount
 * @property string|null $tax_title
 * @property string|null $shipping_method
 * @property string|null $coupon_code
 * @property string $order_date_time
 * @property string $payment_method
 * @property string $payment_reference_code
 * @property string $currency
 * @property string|null $order_pdf
 * @property string|null $order_status
 * @property int $status
 * @property int $is_email_sent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderPdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentReferenceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereServiceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTaxTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUuid($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;
}
