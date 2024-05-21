<?php

namespace App\Http\Controllers\Scholar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransfereeController extends Controller
{
    public function index(Request $request){
        $option = $request->option;
        switch($option){
            default : 
            return inertia('Modules/Scholars/Transferees/Index');
        }
    }
}
