<?php

namespace App\Services\Scholar;

use App\Models\Scholar;
use App\Models\ScholarEducation;
use App\Models\SchoolProspectus;
use App\Http\Resources\Scholar\IndexResource;
use App\Http\Resources\Enrollment\EducationResource;

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

    public static function prospectus($request){
        $data = ScholarEducation::where('scholar_id',$request->id)->first();
        $prospectus = SchoolProspectus::where('school_course_id',$request->subcourse_id)->where('is_active',1)->first();

        if($prospectus){
            $new = [
                'id' => $prospectus->id,
                'year' => $prospectus->school_year
            ];

            $subjects =  json_decode($prospectus->subjects);
            $listahan = [];
            foreach($subjects as $subject){
                $semesters = $subject->semesters;
                foreach($semesters as $semester){
                    $listahans[] = [
                        'semester' => $semester->semester,
                        'is_empty' => (count($semester->courses) > 0) ? false : true,
                        'has_enrolled' => false,
                        'is_delayed' => false
                    ];
                }
                $listahan[] = [
                    'year' => $subject->year_level,
                    'semesters' => $listahans
                ];
                $listahans = [];
            }
            $lists = [];
            array_push($lists, $new);
            $information = [
                'id' => $prospectus->id,
                'year' => $prospectus->school_year,
                'lists' => $lists,
                'is_old' => false,
                'checker' => $listahan,
                'prospectus' => json_decode($prospectus->subjects)
            ];
            $data->subcourse_id = $request->subcourse_id;
            $data->information = json_encode($information);

            if($data->save()){
                $data = ScholarEducation::with('school.school','course','level')->where('scholar_id',$request->id)->first();
                return [
                    'data' => new EducationResource($data),
                    'message' => 'Subcourse was updated successfully!', 
                    'info' => "You have added a prospectus.",
                ];
            }
        }
    }
}
