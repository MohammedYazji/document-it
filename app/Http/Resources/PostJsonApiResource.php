<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class PostJsonApiResource extends JsonApiResource
{
    public function type(): string
    {
        return 'post';
    }

    /**
     * The resource's attributes.
     */
    public $attributes = [
        'title',
        'content',
        'thumbnail_url',
        'published_at'
    ];

    /**
     * The resource's relationships.
     */
    public $relationships = [
        'category',
        'user',
    ];
}
