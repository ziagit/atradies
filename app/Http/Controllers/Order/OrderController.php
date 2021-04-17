<?php

namespace App\Http\Controllers\Order;
use App\Http\Controllers\Controller;
use App\Service;
use App\Option;
use App\Itemtype;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('items')->find($id);
        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(order $order)
    {
        //
    }

    public function services()
    {
        $services = Service::with('steps')->get();
        return response()->json($services);
    }
  
    public function options($id)
    {
        $options = Option::where('step_id',$id)->get();
        return response()->json($options);
    }
    public function deliveryServices()
    {
        $services = Accessory::where('code', 'tl')->orWhere('code', 'in')->orWhere('code', 'ap')->get();
        return response()->json($services);
    }
    public function pickDate()
    {
        $appointment = Accessory::where('code', 'ap')->get();
        return response()->json($appointment);
    }
    public function itemCondition()
    {
        $appointment = Accessory::where('code', 'tm')->orWhere('code', 'dg')->orWhere('code', 'st')->get();
        return response()->json($appointment);
    }
    public function itemType()
    {
        $types = Itemtype::all();
        return response()->json($types);
    }
}
