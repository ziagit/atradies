<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function times(){
        $times = Option::get('times');
        return response()->json($times);
    }
    public function services(){
        $services = Option::get('services');
        return response()->json($services);
    }
    public function needs(){
        $needs = Option::get('needs');
        return response()->json($needs);
    }
    public function budgets(){
        $budgets = Option::get('budgets');
        return response()->json($budgets);
    }
    public function status(){
        $status = Option::get('status');
        return response()->json($status);
    }
    public function categories(){
        $status = Option::all('categories','icon');
        return response()->json($status);
    }
  
}
