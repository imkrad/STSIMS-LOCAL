<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrAnalysis;
use Illuminate\Http\Request;
use App\Http\Resources\TsrResource;
use App\Http\Resources\SampleResource;
use App\Services\DropdownService;

class WelcomeController extends Controller
{

    public function __construct(DropdownService $dropdown){
        $this->dropdown = $dropdown;
    }

    public function index(){
        if(\Auth::check()){
            return inertia('Modules/Dashboard/Index');
        }else{
            return inertia('Auth/Login');
        }
    }
}
