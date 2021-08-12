<?php

namespace App\Http\Controllers\Admin;

use App\Citycode;
use App\Http\Controllers\Controller;
use App\Order;
use App\UserJob;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $orders = Order::with('service')->with('addresses')->with("contacts")->with('user')
        
        ->orderBy("orders.id",'desc')
        ->paginate(8);
        return $orders;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::with('fullAddress','items','jobWithStatus')->find($id);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $user_job = UserJob::where("order_id",$id)->get();
        // $user_job->delete();
        if ($order = Order::find($id)) {
            $order->delete();
            return response()->json(["message" => "Deleted Successfully."]);
        }
        return response()->json(["message" => "Data Not Found!"]);
    }

    public function search(Request $request)
    {
        $orders = Order::with('service')->with('addresses')->with("contacts")->with('user')
        ->orWhereHas('service', function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->keywords . '%');
        })
        ->orWhereHas('user', function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->keywords . '%');
        })
        ->orWhereHas('contacts', function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->keywords . '%')
            ->orWhere('email', 'like', '%' . $request->keywords . '%')
            ->orWhere('phone', 'like', '%' . $request->keywords . '%');
        })
        ->orWhereHas('addresses', function ($q) use ($request) {
            return $q->where('country', 'like', '%' . $request->keywords . '%')
            ->orWhere('city', 'like', '%' . $request->keywords . '%')
            ->orWhere('street', 'like', '%' . $request->keywords . '%')
            ->orWhere('zip', 'like', '%' . $request->keywords . '%');
        })
        
        ->orderBy("orders.id",'desc')
        ->paginate(8);
        return $orders;
    }
}
