<?php

namespace App\Http\Resources\School;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $startDate = Carbon::parse($this->start_at);
        $endDate = Carbon::parse($this->end_at);
        $daysLeft = $startDate->diffInDays($endDate);
        $day = ($daysLeft > 1) ? ' days' : 'day'; 
        return [
            'id' => $this->id,
            'years' => $this->years,
            'validity' => $daysLeft.$day,
            'certification' => $this->certification->name,
            'type' => $this->type,
            'course' => ($this->course->name) ? $this->course->name : $this->course->shortcut,
            'scholars' => $this->course->scholars->count(),
            'course_id' => $this->course->id,
            'prospectuses' => $this->prospectuses
        ];
    }
}
