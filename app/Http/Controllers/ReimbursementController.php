<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Services\DropdownService;
use App\Services\Reimbursement\ViewService;
use App\Services\Reimbursement\SaveService;
use App\Http\Requests\ReimbursementRequest;

class ReimbursementController extends Controller
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
        }
    }

    public function store(ReimbursementRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'reimbursement':
                    return $this->save->reimburse($request);
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
