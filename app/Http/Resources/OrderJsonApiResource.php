<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class OrderJsonApiResource extends JsonApiResource
{
    /**
     * The resource's attributes.
     */
    public $attributes = [
        'uuid',
        'order_total',
        'currency',
        'order_date_time',
        'payment_method',
        'order_status',
        'created_at',
    ];

    /**
     * The resource's relationships.
     */
    public $relationships = [
        'user' => UserJsonApiResource::class,
    ];

    public function toType(Request $request): string
    {
        return 'orders';
    }

    public function toLinks(Request $request): array
    {
        return [
            'self' => url("/api/v2/orders/{$this->resource->getKey()}"),
        ];
    }
}
