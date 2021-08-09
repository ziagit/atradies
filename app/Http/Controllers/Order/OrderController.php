<?php

namespace App\Http\Controllers\Order;
use App\Http\Controllers\Controller;
use App\Service;
use App\Option;
use App\Itemtype;
use App\ServiceUser;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

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
  
    public function filterService(Request $request){
        $services = Service::with("steps")->where("name",'LIKE','%'.$request->service.'%')
        ->orWhere('description','LIKE','%'.$request->service.'%')->get();
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

    /**
     * get the options of specific step
     * @param $step_id
     */
    public function stepOption($step_id)
    {
        $options = Option::where("step_id",$step_id)->get();
        return response()->json($options);
    }

    /**
     * get the services that not selected by auth users
     */
    public function getNotSelectedService()
    {
        $userServices = \DB::table("service_user")->where("user_id",JWTAuth::user()->id)->get();
        $serviceId = [];
        
        foreach($userServices as  $key => $userService)
        {
            $serviceId[$key]  = $userService->service_id;
        }
        $user_services = Service::with("type")->whereIn('id',$serviceId)->get();
        $services  = Service::whereNotIn("id",$serviceId)->get();
        return response()->json(['services' => $services,'user_services' =>$user_services]);
    }

    /**
     * get the services that not selected by auth users
     */
    public function setSelectedService(Request $request)
    {
        $user = User::find(JWTAuth::user()->id);
        $user_service = Service::with("type")->find($request->service);
        ServiceUser::create([
            'service_id'  => $request->service,
            'user_id'     => JWTAuth::user()->id,
        ]);
        return response()->json(['user_service' => $user_service]);
    }

    /**
     * destroy specific user selected service
     */
    public function destroyService($id)
    {
        $user_service = ServiceUser::where("service_id",$id)->where('user_id',JWTAuth::user()->id)->first();
        $service = Service::with("type")->find($id);
        $user_service->delete();
        return response()->json(['user_service' => $service]);
    }
}
