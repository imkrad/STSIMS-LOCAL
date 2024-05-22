<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Services\DropdownService;
use App\Traits\HandlesTransaction;
use App\Services\School\ViewService;
use App\Services\School\SaveService;
use App\Services\School\UpdateService;
use App\Http\Requests\SchoolRequest;

class SchoolController extends Controller
{
    use HandlesTransaction;

    public function __construct(ViewService $view, SaveService $save, UpdateService $update, DropdownService $dropdown)
    {
        $this->dropdown = $dropdown;
        $this->update = $update;
        $this->view = $view;
        $this->save = $save;
    }

    public function index(Request $request){
        $option = $request->option;
        switch($option){
            case 'lists':
                return $this->view->lists($request);
            break;
            case 'courses':
                return $this->view->courses($request);
            break;
            case 'semesters':
                return $this->view->semesters($request);
            break;
            default : 
            return inertia('Modules/Schools/Index',[
                'statistics' => $this->view->statistics()
            ]);
        }
    }

    public function store(SchoolRequest $request){
        if($request->type == 'api'){
            return $this->save->download();
        }else{
            $result = $this->handleTransaction(function () use ($request) {
                switch($request->type){
                    case 'truncate':
                        return $this->save->truncate();
                    break;
                    case 'semester': 
                        return $this->save->semester($request);
                    break;
                    case 'prospectus': 
                        return $this->save->prospectus($request);
                    break;
                    case 'grading':
                        return $this->save->grading($request);
                    break;
                }
            });

            return back()->with([
                'data' => $result['data'],
                'message' => $result['message'],
                'info' => $result['info'],
                'status' => $result['status'],
            ]);
        }
    }

    public function update(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->type){
                case 'prospectus': 
                    return $this->update->prospectus($request);
                break;
                case 'lock': 
                    return $this->update->lock($request);
                break;
                case 'status': 
                    return $this->update->status($request);
                break;
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function show($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $data = $this->view->view($id);
        return inertia('Modules/Schools/Profile/Index',[
            'school' => $data['school'],
            'active' => $data['active'],
            'terms' => $this->dropdown->terms(),
            'counts' => $this->view->counts($id)
        ]);
    }
}
