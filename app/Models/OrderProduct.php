<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $uuid
 * @property int $order_id
 * @property int $product_id
 * @property string $product_name
 * @property string|null $product_image
 * @property string $product_price
 * @property int $product_quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereProductImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereProductQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereUuid($value)
 * @mixin \Eloquent
 */
class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'product_price',
        'product_quantity'
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Order::class);
    }
}

