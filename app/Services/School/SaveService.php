<?php

namespace App\Services\School;

use App\Models\School;
use App\Models\Release;
use App\Models\SchoolCampus;
use App\Models\SchoolName;
use App\Models\SchoolCourse;
use App\Models\ListDropdown;
use App\Models\SchoolGrading;
use App\Models\SchoolSemester;
use App\Models\SchoolProspectus;
use App\Models\ScholarEnrollment;
use App\Models\ScholarEnrollmentSubject;
use App\Jobs\NewSemester;

class SaveService
{
    public function semester($request){
        $data = SchoolSemester::create(array_merge($request->all(),['is_active' => true]));
        if($data){
            $ids = SchoolSemester::where('school_id',$request->school_id)->where('is_active',1)->where('id','!=',$data->id)->pluck('id');
            foreach($ids as $id){
                $scholar = ScholarEnrollment::where('is_enrolled',0)->where('semester_id',$id)->update(['is_missed' => 1]);
            }
            SchoolSemester::where('school_id',$request->school_id)->where('id','!=',$data->id)->update(['is_active' => 0]);
            NewSemester::dispatch($data->id)->delay(now()->addSeconds(10));
        }
        return [
            'data' => $data,
            'message' => 'Semester was added successfully!', 
            'info' => "You've successfully added a semester.",
        ];
    }

    public function grading($request){
        $data = SchoolGrading::create($request->all());
        return [
            'data' => $data,
            'message' => 'Grading was added successfully!', 
            'info' => "You've successfully added a grading.",
        ];
    }

    public function prospectus($request){
        $level = ListDropdown::where('classification','Level')->select('name','others')->get();
        $years = $request->years;
        $term = $request->term;
        $semesters = ListDropdown::where('classification',$term)->pluck('name');

        $group = []; $courses = [];

        for ($i = 0; $i < $years; ++$i) {
            $sem = [];
            foreach($semesters as $key=>$semester){
                $sem[] = ['semester' => $semester,'total' => 0,'courses' => $courses];
            }
            $group[] = [
                'year_level' => $level[$i]['others'],
                'year_ordinal' => $level[$i]['name'],
                'semesters' => $sem
            ];
        }
        $request['subjects'] = json_encode($group,true);
        $request['added_by'] = \Auth::user()->id;

        $data = SchoolProspectus::create($request->all());
        return $data;
    }

    public function truncate(){
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        SchoolSemester::truncate();
        ScholarEnrollment::truncate();
        ScholarEnrollmentSubject::truncate();
        Release::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return back()->with([
            'data' => true,
            'message' => 'Database Truncated Succesfully',
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]);
    }
}
