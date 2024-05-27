<?php

namespace App\Http\Resources\Reimbursement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SemesterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->id,
            'id' => $this->id,
            'year' => $this->semester->year,
            'academic_year' => $this->semester->academic_year.' - '.$this->semester->semester->name,
            'start_at' => $this->semester->start_at,
            'end_at' => $this->semester->end_at,
            'semester' => $this->semester->semester->name,
            'type' => $this->semester->semester->others,
        ];
    }
}
