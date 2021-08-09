<?php

namespace App\Http\Controllers\Admin\Jobs;

use App\Http\Controllers\Controller;
use App\Option;
use App\Step;
use Illuminate\Http\Request;

class OptionController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options= Option::with("service")->with('step')->paginate(5);
        return response()->json($options);
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
        $this->validate($request,
        [
            'title' =>  'required',
            'step'   =>  'required',
            'service'  => 'required',
        ]);
        $option = New Option();
        $option->title = $request->title;
        $option->step_id=$request->step;
        $option->service_id = $request->service;
        $option->save();
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
        $option = Option::find($id);
        $option->title = $request->title;
        $option->step_id=$request->step;
        $option->service_id = $request->service;
        $option->update();
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
        $option = Option::find($id);
        $option->delete();
        return response()->json(['message'=>'Deleted Successfully!'],200);
    }
    public function steps($service_id){
        $steps = Step::where("service_id",$service_id)->get();
        return response()->json($steps);
    }
}
