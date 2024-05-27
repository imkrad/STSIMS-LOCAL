<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Http\Requests\ReleaseRequest;
use App\Services\DropdownService;
use App\Services\FinancialBenefit\ViewService;
use App\Services\FinancialBenefit\SaveService;

class FinancialBenefitController extends Controller
{   
    use HandlesTransaction;
    
    public function __construct(ViewService $view, SaveService $save, DropdownService $dropdown)
    {
        $this->view = $view;
        $this->save = $save;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        $option = $request->option;
        switch($option){
            case 'lists':
                return $this->view->lists($request);
            break;
            case 'benefits':
                return $this->view->benefits($request);
            break;
            default : 
            return inertia('Modules/FinancialBenefits/Index',[
                'latest' => $this->view->generate(),
                'privileges' => $this->dropdown->privileges()
            ]);
        }
    }

    public function store(ReleaseRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            $type = $request->type;
            switch($type){
                case 'completed':
                    return $this->save->completed($request);
                break;
                case 'pending':
                    return $this->save->pending($request);
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
