<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Shipper;
use App\Item;
use App\Order;
use App\Accessory;
use App\Carrier;
use App\Notifications\JobCreated;
use App\Address;
use App\Contact;
use App\Country;
use App\Jobs\SendJobMessage;
use App\Mail\SendJobEmail;
use App\Role;
use App\User;
use App\UserJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        $user = null;
        $userId = null;
        if(JWTAuth::user())
        {
            $userId = JWTAuth::user()->id;
        }
        else{
            $user = User::where("email",$request->contact['email'])->first();
            if($user != ""){
                $userId = $user->id;
            }
            else{
                $user = User::create(
                    [
                        'name'  => $request->contact['name'],
                        'email' => $request->contact['email'],
                        'password'  => bcrypt("password123"),
                    ]
                    );
                    $userId = $user->id;
                    $role = Role::where('name', '=', 'shipper')->first();
                    $user->roles()->attach($role);
            }
        }
        
        if ($userId) {
            $orderId = $this->storeOrder($request, $userId);
            
            $users = User::select('users.name','users.id','users.email','service_user.id as serviceUserId')->join("service_user",'users.id','service_user.user_id')
            ->where('service_user.service_id',$request->order_service)->get();
             if($this->createNewJob($orderId, $userId, $users))
             {
                return response()->json(['status' => true,"message" => "Saved successfully!"], 200);
             }

            
            // return response()->json($user->notifications);
            return response()->json(['status' => false]);
        }
      }catch(Exception $e){
          return response()->json($e->getMessage());
      }
    }

    

    public function storeOrder($request,$userId)
    {
        $addressId = $this->storeAddress($request);

        $contactId = $this->storeContact($request);
    
        $order =new Order();
        $order->budget = $request->budget ? $request->budget['budget'] : null;
        $order->need = $request->need ?$request->need['need']:null;
        $order->service = $request->servicetype ? $request->servicetype['servicetype'] : null;
        $order->status = $request->status ? $request->status['status']:null;
        $order->location_type = $request->locationtype ? $request->locationtype['locationtype']:null;
        $order->time = $request->time ? $request->time['time']:null;
        $order->description = $request->description ? $request->description['description']:null;
        $order->contact_id = $contactId;
        $order->address_id = $addressId;
        $order->service_id = $request->order_service ? $request->order_service:null;
        $order->user_id  = $userId;
        


        $order->save();
        
        return $order->id;
    }

    public function storeContact($request){
        $contact = [
            'name' => $request->contact ? $request->contact['name']:null,
            'phone' => $request->contact ? $request->contact['phone']:null,
            'email' => $request->contact ? $request->contact['email']:null
        ];
        $id = Contact::insertGetId($contact);
        return $id;
    }
    public function storeAddress($request){
        // $countryId = Country::where('name', $request->address['country'])->first();
        $addressAddress = [
            'street' => $request->address ? $request->address['street'] : null,
            'street_number' => $request->address ? $request->address['street_number'] : null,
            'zip' => $request->address ? $request->address['zip'] : null,
            'city' => $request->address ? $request->address['city'] : null,
            'state' => $request->address ? $request->address['state'] : null,
            'country' => $request->address ? $request->address['country'] : null
        ];
        $addressId = Address::insertGetId($addressAddress);
        return $addressId;
      
    }

    public function createNewJob($order, $userId,$users)
    {
         $admin = User::find(1);

        foreach ($users as $key => $user) {
            $user_job = new UserJob();
            $user_job->order_id = $order;
            $user_job->user_id = $user->id;
            $user_job->customer_id = $userId;
            $user_job->save();
            // $user  = Carrier::with('user')->find($request->carrier['id'])->user;

            //  $user->notify(new JobCreated($job));

            // $admin->notify(new JobCreated($job));
            SendJobMessage::dispatch($user,$user_job);
        }
        return true;
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
