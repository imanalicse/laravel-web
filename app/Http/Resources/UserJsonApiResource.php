<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class UserJsonApiResource extends JsonApiResource
{
    /**
     * The resource's attributes.
     */
    public $attributes = [
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

    /**
     * The resource's relationships.
     */
    public $relationships = [
        'orders' => OrderJsonApiResource::class,
    ];

    public function toType(Request $request): string
    {
        return 'users';
    }

    public function toLinks(Request $request): array
    {
        return [
            'self' => url("/api/v2/users/{$this->resource->getKey()}"),
        ];
    }
}
