<?php

namespace App\Services\Scholar;

use App\Models\Scholar;
use App\Models\ScholarProfile;
use App\Models\ScholarAddress;
use App\Models\ScholarEducation;
use App\Http\Resources\Scholar\IndexResource;

class ViewService
{
    public function lists($request){
        $info = (!empty(json_decode($request->info))) ? json_decode($request->info) : NULL;
        $filter = (!empty(json_decode($request->subfilters))) ? json_decode($request->subfilters) : NULL;
        $keyword = $info->keyword;

        $data = IndexResource::collection(
            Scholar::with('profile')
            ->with('addresses.region','addresses.province','addresses.municipality','addresses.barangay')
            ->with('program:id,name','subprogram:id,name','category:id,name','status:id,name,type,color,others')
            ->with('education.school.school','education.course','education.level')
            ->whereHas('profile',function ($query) use ($keyword) {
                $query->when($keyword, function ($query, $keyword) {
                    $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')
                    ->where(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%')
                    ->orWhere('spas_id','LIKE','%'.$keyword.'%');
                });
            })
            ->whereHas('addresses',function ($query) use ($filter) {
                if(!empty($filter)){
                    (property_exists($filter, 'region')) ? $query->where('region_code',$filter->region)->where('is_permanent',1) : '';
                    (property_exists($filter, 'province')) ? $query->where('province_code',$filter->province)->where('is_permanent',1) : '';
                    (property_exists($filter, 'municipality')) ? $query->where('municipality_code',$filter->municipality)->where('is_permanent',1) : '';
                    (property_exists($filter, 'barangay')) ? $query->where('barangay_code',$filter->barangay)->where('is_permanent',1) : '';
                }
            })
            ->whereHas('education',function ($query) use ($filter) {
                if(!empty($filter)){
                    (property_exists($filter, 'school')) ? $query->where('school_id',$filter->school) : '';
                    (property_exists($filter, 'course')) ? $query->where('course_id',$filter->course) : '';
                    (property_exists($filter, 'level')) ? $query->where('level_id',$filter->level) : '';
                }
            })
            ->where(function ($query) use ($info,$filter) {
                if(!empty($filter)){
                    (property_exists($filter, 'program')) ? $query->where('program_id',$filter->program) : '';
                    (property_exists($filter, 'subprogram')) ? $query->where('subprogram_id',$filter->subprogram) : '';
                }
                if(!empty($info)){
                    ($info->year == null) ? '' : $query->where('awarded_year',$info->year);
                    if($info->type != null){
                        $query->whereHas('status',function ($query) {
                            $query->where('type','ongoing');
                        });
                    }
                }
             })
            ->paginate($info->counts)
            ->withQueryString()
        );
        return $data;
    }   

    public function statistics(){
        $array = [
            'statistics' => [
                'total' => Scholar::count(),
                'ongoing' =>  Scholar::whereHas('status',function ($query) {
                    $query->where('type','ongoing');
                })->count(),
                'progress' => [
                    Scholar::whereHas('status',function ($query) {
                        $query->where('type','ongoing');
                    })->count(),
                    Scholar::whereHas('status',function ($query) {
                        $query->where('name','Graduated');
                    })->count(),
                     Scholar::count()
                ],
                'types' => [
                    Scholar::where('is_undergrad',1)->count(),
                    Scholar::where('is_undergrad',0)->count(),
                ],
                'sync_count' => Scholar::where('is_synced',0)->count() + ScholarProfile::where('is_synced',0)->count() + ScholarAddress::where('is_synced',0)->count() + ScholarEducation::where('is_synced',0)->count()
            ]
        ];
        return $array;
    }
}
