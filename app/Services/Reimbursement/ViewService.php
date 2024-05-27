<?php

namespace App\Services\Reimbursement;

use App\Models\Scholar;
use App\Http\Resources\Reimbursement\SearchResource;

class ViewService
{
    public function search($request){
        $data = Scholar::with('profile','status','program')
        ->with('enrollments:id,semester_id,scholar_id','enrollments.semester.semester')
        ->when($request->keyword, function ($query, $keyword) {
            $query->whereHas('profile',function ($query) use ($keyword) {
                $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')
                ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%')
                ->orWhere('spas_id','LIKE','%'.$keyword.'%');
            });
        })
        ->take(5)->get();
        return SearchResource::collection($data);
    }
}
