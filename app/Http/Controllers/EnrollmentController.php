<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DropdownService;
use App\Traits\HandlesTransaction;
use App\Services\Enrollment\ViewService;
use App\Services\Enrollment\SaveService;
use App\Http\Requests\EnrollmentRequest;

class EnrollmentController extends Controller
{
    use HandlesTransaction;

    public function __construct(ViewService $view, SaveService $save, DropdownService $dropdown)
    {
        $this->dropdown = $dropdown;
        $this->view = $view;
        $this->save = $save;
    }

    public function index(Request $request){
        $option = $request->option;
        switch($option){
            case 'search':
                return $this->view->search($request);
            break;
            case 'activeprospectus':
                return $this->view->activeprospectus($request);
            break;
            default : 
            return inertia('Modules/Enrollments/Index');
        }
    }

    public function store(EnrollmentRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->type){
                case 'enrollment':
                    return $this->save->enrollment($request);
                break;
                case 'grade':
                    return $this->save->grade($request);
                break;
                case 'lock':
                    return $this->save->lock($request);
                break;
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
            'type' => $request->type
        ]);
    }

    public function update(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->type){
                case 'switch': 
                    return $this->save->switch($request);
                break;
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
            'type' => $request->type
        ]);
    }
}
