<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\Test;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TestController extends Controller
{
    public function index(){
        $tests = User::all();
        return response()->json($tests);
    }
    public function store(Request $request){
        $test = new Test();
        $test->test = $request->test;
        $test->save();
        return response()->json(['message'=>'Saved successfully!'], 200);
    }
    public function destroy($id){
        $test = Test::find($id);
        $test->delete();
        return response()->json(['message'=>'Deleted successfully!'], 200);
    }

}
