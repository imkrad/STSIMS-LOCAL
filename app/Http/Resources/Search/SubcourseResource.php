<?php

namespace App\Http\Resources\Search;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->id,
            'type' => $this->type
        ];
    }
}
