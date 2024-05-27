<?php

namespace App\Http\Controllers\Scholar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownService;
use App\Services\Scholar\ApiService;
use App\Services\Scholar\ViewService;
use App\Services\Scholar\SaveService;
use App\Services\Scholar\TruncateService;
use App\Traits\HandlesTransaction;
use App\Http\Requests\ScholarRequest;

class ListController extends Controller
{
    use HandlesTransaction;

    public function __construct(ApiService $api, ViewService $view, SaveService $save, TruncateService $truncate, DropdownService $dropdown){
        $this->dropdown = $dropdown;
        $this->truncate = $truncate;
        $this->view = $view;
        $this->save = $save;
        $this->api = $api;
    }

    public function index(Request $request){
        $option = $request->option;
        switch($option){
            case 'lists':
                return $this->view->lists($request);
            break;
            default : 
            return inertia('Modules/Scholars/Lists/Index',[
                'dropdowns' => [
                    'programs' => $this->dropdown->programs(),
                    'subprograms' => $this->dropdown->subprograms(),
                    'levels' => $this->dropdown->levels(),
                    'regions' => $this->dropdown->regions(),
                    'statuses' => $this->dropdown->scholar_statuses(),
                ],
                'statistics' => $this->view->statistics()
            ]);
        }
    }

    public function store(Request $request){
        $option = $request->option;
        switch($option){
            case 'api':
                return $this->api->option($request);
            break;
            case 'truncate':
                return $this->truncate->truncate($request);
             break;
        }
    }

    public function update(ScholarRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'scholar': 
                    return $this->save->scholar($request);
                break;
                case 'prospectus': 
                    return $this->save->prospectus($request);
                break;
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
            'type' => $request->type, 
        ]);
    }
}
