<?php

namespace App\Services;

use App\Models\{
    LocationRegion,
    LocationProvince,
    LocationMunicipality,
    LocationBarangay,
    ListProgram,
    ListDropdown,
    ListStatus,
    ListPrivilege,
    ListRole
};
use App\Http\Resources\TestserviceResource;

class DropdownService
{
    public function regions(){
        $data = LocationRegion::all()->map(function ($item) {
            return [
                'value' => $item->code,
                'name' => $item->region
            ];
        });
        return $data;
    }

    public function provinces($code){
        $data = LocationProvince::where('region_code',$code)->get()->map(function ($item) {
            return [
                'value' => $item->code,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function municipalities($code){
        $data = LocationMunicipality::where('province_code',$code)->get()->map(function ($item) {
            return [
                'value' => $item->code,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function barangays($code){
        $data = LocationBarangay::where('municipality_code',$code)->get()->map(function ($item) {
            return [
                'value' => $item->code,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function programs(){
        $data = ListProgram::where('is_sub',0)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function subprograms(){
        $data = ListProgram::where('is_sub',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function levels(){
        $data = ListDropdown::where('classification','Level')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->others
            ];
        });
        return $data;
    }

    public function terms(){
        $data = ListDropdown::where('type','term')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'classification' => $item->classification
            ];
        });
        return $data;
    }

    public function scholar_statuses(){
        $data = ListStatus::whereIn('type',['Progress','Ongoing'])->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'type' => $item->type
            ];
        });
        return $data;
    }

    public function qualifier_statuses(){
        $data = ListStatus::where('type','Qualifier')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function privileges(){
        $data = ListPrivilege::where('is_reimburseable',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function roles(){
        $data = ListRole::where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'has_designation' => $item->has_designation
            ];
        });
        return $data;
    }
}
