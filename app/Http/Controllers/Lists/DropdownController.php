<?php

namespace App\Http\Controllers\Lists;

use App\Models\ListAgency;
use App\Models\ListCourse;
use App\Models\SchoolCampus;
use App\Models\SchoolCourse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Lists\DropdownService;
use App\Traits\HandlesTransaction;
use App\Http\Resources\Search\SchoolResource;
use App\Http\Resources\Search\CourseResource;
use App\Http\Resources\Search\SubcourseResource;

class DropdownController extends Controller
{
    use HandlesTransaction;

    public function __construct(DropdownService $dropdown){
        $this->dropdown = $dropdown;
        $this->id = config('app.agency');
    }

    public function index(Request $request){
        $options = $request->option;
        switch($options){
            case 'schools':
                return $this->schools($request);
            break;
            case 'courses':
                return $this->courses($request);
            break;
            case 'courses2':
                return $this->courses2($request);
            break;
            case 'subcourses':
                return $this->subcourses($request);
            break;
            default: 
            return inertia('Modules/Lists/Dropdowns/Index',[
                'dropdowns' => $this->dropdown->lists()
            ]);
        }
    }

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            return $this->dropdown->save($request);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function schools($request){
        $keyword = $request->keyword;
        $region = $request->region;
        $is_endorsed = $request->input('is_endorsed');
        $code = ListAgency::where('id',$this->id)->value('region_code');
        $data = SchoolCampus::with('school','term')
        // ->where(function ($query) use ($code,$is_endorsed) {
        //     ($is_endorsed) ? $query->where('assigned_region','!=',$code) : $query->where('assigned_region',$code);
        // })
        ->when($request->keyword, function ($query, $keyword) {
            $query->whereHas('school',function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%'.$keyword.'%');
            })->orWhere(function ($query) use ($keyword) {
                $query->where('campus', 'LIKE', '%'.$keyword.'%');
            })->orderBy('is_main','desc');
        })
        ->when($request->region, function ($query, $region) {
            $query->where('assigned_region',$region)->orderBy('is_main','desc');
        })
        ->whereHas('school',function ($query) {
            $query->orderBy('name','ASC');
        })
        ->get();

        return SchoolResource::collection($data);
    }

    public function courses(Request $request){
        $data = ListCourse::get();
        return CourseResource::collection($data);
    }

    public function courses2(Request $request){
        $school = $request->school;
        $data = ListCourse::whereHas('lists',function ($query) use ($school) {
            $query->where('school_id',$school);
        })->get();
        return CourseResource::collection($data);
    }

    public function subcourses(Request $request){
        $school = $request->school_id;
        $course = $request->course_id;
        $data = SchoolCourse::where('school_id',$school)->where('course_id',$course)->get();
        return SubcourseResource::collection($data);
    }
}
