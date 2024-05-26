<?php

namespace App\Services\School;

use App\Models\SchoolProspectus;

class UpdateService
{
    public function prospectus($request){
        $data = SchoolProspectus::where('id',$request->id)->update($request->except('id','type','editable'));
        $data = SchoolProspectus::where('id',$request->id)->first();
        $data = SchoolProspectus::where('school_course_id',$data->school_course_id)->orderBy('created_at','DESC')->get();
        return [
            'data' => $data,
            'message' => 'Prospectus updated Succesfully!', 
            'info' => "You've successfully updated prospectus.",
        ];
    }

    public static function lock($request){
        $data = SchoolProspectus::where('id',$request->id)->update(['is_locked' => $request->is_locked]);
        $data = SchoolProspectus::where('id',$request->id)->first();
        $data = SchoolProspectus::where('school_course_id',$data->school_course_id)->orderBy('created_at','DESC')->get();
        return [
            'data' => $data,
            'message' => 'Prospectus locked Succesfully!', 
            'info' => "You've successfully prospectus status.",
        ];
    }

    public static function status($request){
        $data = SchoolProspectus::where('id',$request->id)->update(['is_active' => $request->is_active]);
        $data1 = SchoolProspectus::where('id',$request->id)->first();
        $data = SchoolProspectus::where('school_course_id',$data1->school_course_id)->orderBy('created_at','DESC')->get();

        $update = SchoolProspectus::where('id','!=',$request->id)->where('school_course_id',$data1->school_course_id)->update(['is_active' => 0]);
        return [
            'data' => $data,
            'message' => 'Prospectus status Succesfully!', 
            'info' => "You've successfully prospectus status.",
        ];
    }
}
