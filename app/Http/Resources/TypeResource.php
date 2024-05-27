<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        
        // return parent::toArray($request);
        switch($this->roleable_type){
            case 'App\Models\SchoolCampus':
                $count = strlen($this->roleable->school->name);
                if($count < 20){
                    if($this->roleable->is_main){
                        $name = ucwords(strtolower($this->roleable->school->name));
                    }else{
                        $name = ucwords(strtolower($this->roleable->school->name)).' - '.$this->roleable->campus;
                    }
                }else{
                    if($this->roleable->is_main){
                        $name = strtoupper($this->roleable->school->shortcut);
                    }else{
                        $name = strtoupper($this->roleable->school->shortcut).' - '.$this->roleable->campus;
                    }
                }
            break;
            case 'App\Models\LocationRegion':
                $name = $this->roleable->region;
            break;
            case 'App\Models\LocationProvince':
                $name = $this->roleable->name;
            break;
        }
        return [
            'name' => $name
        ];
    }
}
