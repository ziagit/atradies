<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Shipper;
use App\Item;
use App\Order;
use App\Accessory;
use App\Carrier;
use App\Job;
use App\Notifications\JobCreated;
use App\Address;
use App\Contact;
use App\Country;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
      try{
        $shipperId = $this->storeShipper($request->shipper);

        if ($shipperId) {
            $orderId = $this->storeOrder($request, $shipperId);
            
            $job = $this->createNewJob($orderId, $shipperId, $request->carrier);

            $user  = Carrier::with('user')->find($request->carrier['id'])->user;
            $admin = User::find(1);

            $user->notify(new JobCreated($job));

            $admin->notify(new JobCreated($job));
            return response()->json($user->notifications);
        }
      }catch(Exception $e){
          return response()->json($e->getMessage());
      }
    }
    public function storeOrder($request, $shipperId)
    {
        $contactId = $this->storeContact($request);
        $addressId = $this->storeAddress($request);
    
        $order =new Order();
        $order->budget = $request->budget;
        $order->need = $request->need;
        $order->service = $request->service;
        $order->status = $request->status;
        $order->time = $request->time;
        $order->instructions = $request->instructions;
        $order->contact_id = $contactId;
        $order->address_id = $addressId;
        

        $order->shipper_id = $shipperId;

        $order->save();
        
        
        return $order->id;
    }

    public function storeContact($request){
        $contact = [
            'name' => $request->contact['name'],
            'phone' => $request->contact['phone'],
            'email' => $request->contact['email']
        ];
        $id = Contact::insertGetId($contact);
        return $id;
    }
    public function storeAddress($request){
        $countryId = Country::where('name', $request->address['country'])->first();
        $addressAddress = [
            'street' => $request->address['street'],
            'street_number' => $request->address['street_number'],
            'zip' => $request->address['zip'],
            'city' => $request->address['city'],
            'state' => $request->address['state'],
            'formatted_address' => $request->address['formatted_address'],
            'country_id' => $countryId->id
        ];
        $addressId = Address::insertGetId($addressAddress);
        return $addressId;
      
    }

    public function createNewJob($order, $shipperId, $carrier)
    {
        $job = new Job();
        $job->order_id = $order;
        $job->shipper_id = $shipperId;
        $job->carrier_id = $carrier['id'];
        $job->save();
        return $job;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::with('orderDetail', 'jobstatus')->find($id);
        return $job;
    }
    public function carrierContacts($id)
    {
        $carrier = Carrier::with('contact')->find($id);
        return $carrier;
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
        //
    }
}
