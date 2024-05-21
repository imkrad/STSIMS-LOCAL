<?php

namespace App\Http\Resources\Search;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'value' =>  $this->id,
            'name' => ($this->name == '') ? $this->shortcut : $this->name
        ];
    }
}
