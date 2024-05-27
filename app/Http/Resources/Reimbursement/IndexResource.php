<?php

namespace App\Http\Resources\Reimbursement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'attachment' => json_decode($this->attachment),
            'is_approved' => $this->is_approved,
            'is_reimbursed' => $this->is_reimbursed,
            'benefit' => $this->benefit,
            'semester' => $this->semester,
            // 'scholar' => new ProfileResource($this->scholar->profile),
            'checked_by' => $this->checked_by
        ];
    }
}
