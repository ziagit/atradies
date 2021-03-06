<?php

namespace App\Http\Controllers\Admin\Jobs;

use App\Http\Controllers\Controller;
use App\Service;
use App\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $steps= Step::with('service')->paginate(5);
        return response()->json($steps);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // <md-option value="location">Location</md-option>
        // <md-option value="contact">Location</md-option>
        // <md-option value="multichoices">Multi choices</md-option>
        // <md-option value="onechoice">One choice</md-option>
        // <md-option value="description">Description</md-option>
        if($request->route == 'location'){
            $request['showing']  = 1;
        }
        elseif($request->route == 'onechoice')
        {
            $request['showing']  = 2;
        }
        elseif($request->route == 'multichoices')
        {
            $request['showing']  = 3;
        }
        elseif($request->route == 'multichoices')
        {
            $request['showing']  = 3;
        }
        $step = New Step();
        $step->title = $request->title;
        $step->route=$request->route;
        $step->service_id=$request->service;
        $step->save();
        return response()->json(['message'=>'Saved Successfully!'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $step = Step::find($id);
        $step->title = $request->title;
        $step->route = $request->route;
        $step->service_id=$request->service;
        $step->update();
        return response()->json(['message'=>'Updated Successfully!'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $step = Step::find($id);
        $step->delete();
        return response()->json(['message'=>'Deleted Successfully!'],200);
    }
    public function services(){
        $services = Service::all();
        return response()->json($services);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $steps= Step::with('service')
        ->where("title","LIKE","%".$request->keywords."%")->paginate(5);
        return response()->json($steps);
    }
}
