<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->profile->firstname.' '.$this->profile->lastname,
            'firstname' => $this->profile->firstname,
            'lastname' => $this->profile->lastname,
            'middlename' => $this->profile->middlename,
            'avatar' => 'avatar.jpg'
        ];
    }
}
