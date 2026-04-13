<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class ProductJsonApiResource extends JsonApiResource
{
    /**
     * The resource's attributes.
     */
    public $attributes = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'created_at',
        'updated_at',
    ];

    /**
     * The resource's relationships.
     */
    public $relationships = [];

    public function toType(Request $request): string
    {
        return 'products';
    }

    public function toLinks(Request $request): array
    {
        return [
            'self' => url("/api/v2/products/{$this->resource->getKey()}"),
        ];
    }
}
