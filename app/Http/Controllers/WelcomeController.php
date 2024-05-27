<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use App\Models\User;
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

    public function activation(){
        if(\Auth::user()->is_active){
            return redirect()->intended(route('dashboard', absolute: false));
        }else{
            return inertia('Auth/Activation');
        }
    }

    public function activate(Request $request){
        $id = \Auth::user()->id;
        $data = User::findOrFail($id);
        $data->is_active = 1;
        if($data->save()){
            return redirect()->intended(route('dashboard', absolute: false));
        }
    }
}
