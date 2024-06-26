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
use App\Traits\HandlesCurl;
use Carbon\Carbon;

class SaveService
{
    use HandlesCurl;

    public function __construct()
    {
        $this->link = config('app.api_link');
        $this->api = config('app.api_key');
    }

    public function semester($request){
        $start = Carbon::parse($request->start_at)->format('Y-m-d');
        $end = Carbon::parse($request->end_at)->format('Y-m-d');
       
        $data = SchoolSemester::create(array_merge($request->all(),['is_active' => true,'start_at' => $start, 'end_at' => $end]));
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
        return [
            'data' => $data,
            'message' => 'Prospectus added Succesfully!', 
            'info' => "You've successfully added a prospectus.",
        ];
    }

    public function truncate(){
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        SchoolSemester::truncate();
        ScholarEnrollment::truncate();
        ScholarEnrollmentSubject::truncate();
        Release::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return [
            'data' => [],
            'message' => 'Database Truncated Succesfully!', 
            'info' => "You've successfully truncate.",
        ];
    }

    public function download(){
        $response = $this->handleCurl('schools','download');
        $lists = json_decode($response);

        try{
            $result = \DB::transaction(function () use ($lists){
                $schools = array();
                $campusess = array();
                $courses = array();
                $namess = array();                
                foreach($lists as $data){
                    $school = (array)$data;
                    $campuses = array_splice($school,9);
                    $school['is_synced'] = 1;
                    $count = School::where('id',$school['id'])->count();
                    if($count == 0){
                        $q = School::insertOrIgnore($school);
                        array_push($schools,$q);
                    }
                    foreach($data->campuses as $campus)
                    {   
                        $lst1 = (array)$campus;
                        $names = array_pop($lst1);
                        $courses = array_pop($lst1);
                        $lst1['is_synced'] = 1;
                        // $q = SchoolCampus::insertOrIgnore($lst1);
                        $count = SchoolCampus::where('id',$lst1['id'])->count();
                        if($count == 0){
                            $q = SchoolCampus::insertOrIgnore($lst1);
                            array_push($campusess,$q);
                        }
                       foreach($courses as $course){
                            $course = (array)$course;
                            $course['is_synced'] = 1;
                            $count = SchoolCourse::where('id',$course['id'])->count();
                            if($count == 0){
                                $q = SchoolCourse::insertOrIgnore((array)$course);
                                array_push($courses,$q);
                            }
                        }
                        foreach($names as $name){
                            $name = (array)$name;
                            $name['is_synced'] = 1;
                            $count = SchoolName::where('id',$name['id'])->count();
                            if($count == 0){
                                $q = SchoolName::insertOrIgnore((array)$name);
                                array_push($namess,$q);
                            }
                        }
                    } 
                }

                $result = [
                    'success' => $schools,
                    'failed' => $campusess,
                    'duplicate' => $courses,
                    'names' => $namess
                ];
                return $result;
            });
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return $result;
    }
}
