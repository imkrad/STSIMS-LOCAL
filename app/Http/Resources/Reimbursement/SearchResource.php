<?php

namespace App\Http\Resources\Reimbursement;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $id = $hashids->encode($this->id);
        
        return [
            'id' => $this->id,
            'code' => $id,
            'status' => $this->status,
            'program' => $this->program,
            'profile' => new ProfileResource($this->profile), 
            'semesters' => SemesterResource::collection($this->enrollments),
        ];
    }
}
