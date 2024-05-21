<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Sync\ListService;
use App\Services\Sync\LocationService;
use App\Services\Sync\SchoolService;

class SyncController extends Controller
{
    public function __construct(
        ListService $list, 
        LocationService $location, 
        SchoolService $school
        )
    {
        $this->list = $list;
        $this->location = $location;
        $this->school = $school;
    }

    public function checkApi(){
        return $this->location->checkConnection();
    }

    public function fetchCount(){
        $array = [
            'lists' => $this->list->fetchCount(),
            'locations' => $this->location->fetchCount(),
            'schools' => $this->school->fetchCount(),
        ];
        return $array;
    }

    public function locations(){
        return $this->location->fetch();
    }

    public function lists(){
        return $this->list->fetch();
    }

    public function schools(){
        return $this->school->fetch();
    }
}
