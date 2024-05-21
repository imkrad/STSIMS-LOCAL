<?php

namespace App\Services\Scholar;

use App\Models\Scholar;
use App\Http\Resources\Scholar\IndexResource;

class SaveService
{
    public function scholar($request){
        $data = Scholar::where('id',$request->id)->update($request->except('option'));
        $data = Scholar::where('id',$request->id)
        ->with('addresses.region','addresses.province','addresses.municipality','addresses.barangay')
        ->with('profile')
        ->with('program:id,name','subprogram:id,name','category:id,name','status:id,name,type,color,others')
        ->with('education.school.school','education.course','education.level')
        ->first();

        return [
            'data' => new IndexResource($data),
            'message' => 'Scholar was successfully updated!', 
            'info' => "You've successfully updated the scholar status.",
        ];
    }
}
