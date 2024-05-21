<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DropdownService;

class DashboardController extends Controller
{
    public function __construct(DropdownService $dropdown){
        $this->dropdown = $dropdown;
    }

    public function index(){
        return inertia('Modules/Dashboard/Index');
    }
}
