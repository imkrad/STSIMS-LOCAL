<?php

namespace App\Http\Controllers\User\Utility;

use App\Models\Log;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\AuthenticationResource;

class LogController extends Controller
{
    public function activity(Request $request){
        $data = Activity::with('causer.profile')->orderBy('created_at','DESC')->paginate($request->count);
        return ActivityResource::collection($data);
    }

    public function authentication(Request $request){
        $data = Log::lists($request->counts);
        return AuthenticationResource::collection($data);
    }
}
