<?php

namespace App\Http\Controllers\admin\Jobs;

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
        $step = New Step();
        $step->title = $request->title;
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
}
