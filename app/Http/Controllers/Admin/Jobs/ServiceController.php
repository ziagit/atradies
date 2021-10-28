<?php

namespace App\Http\Controllers\Admin\Jobs;

use App\Http\Controllers\Controller;
use App\Service;
use Exception;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services= Service::with('type')->paginate(5);
        return response()->json($services);
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
        try {
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $icon_name = time() . '.' . $file->getClientOriginalName();
                $file->move(public_path('images/uploads'), $icon_name);
            } else {
                $icon_name = "undefined";
            }
        } catch (Exception $e) {
            die('File did not upload: ' . $e->getMessage());
        }
        $service = New Service();
        $service->name = $request->name;
        $service->type_id=$request->type;
        $service->icon = $icon_name;
        $service->description  = $request->description;
        $service->save();
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
        $service = Service::find($id);
        if ($request->hasFile('icon')) {

            $old_icon_path = public_path('images/uploads/' . $service->icon);
            if (file_exists($old_icon_path)) {
                @unlink($old_icon_path);
            }
            $file = $request->file('icon');
            $icon_name = time() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images/uploads'), $icon_name);
        } else {
            $icon_name = $service->icon;
        }
        $service->icon = $icon_name;
        $service->name = $request->name;
        $service->type_id = $request->type;
        $service->description  = $request->description;
        $service->update();
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
        $service = Service::find($id);
        $old_icon_path = public_path('images/uploads/' . $service->icon);
        if (file_exists($old_icon_path)) {
            @unlink($old_icon_path);
        }
        $service->delete();
        return response()->json(['message'=>'Deleted Successfully!'],200);
    }

    public function getService()
    {
        $services = Service::all();
        return response()->json($services);
    }
}
