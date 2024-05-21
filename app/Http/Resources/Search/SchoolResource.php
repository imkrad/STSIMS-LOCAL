<?php

namespace App\Http\Resources\Search;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $name = ucwords(strtolower($this->school->name));
       
        if($this->is_main){
            if(!$this->is_alone){
                $campus = '';
            }else{
                $campus = '';
            }
        }else{
            if($this->is_alone){
                $campus = '';
            }else{
                $campus = '-'.ucwords(strtolower($this->campus));
            }
        }

        return [
            'value' => $this->id,
            'name' => $name.$campus,
            'term' => $this->term->name,
            'region' => $this->assigned_region
        ];
    }
}
