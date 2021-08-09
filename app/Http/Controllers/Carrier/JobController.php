<?php

namespace App\Http\Controllers\Carrier;
use App\Http\Controllers\Controller;
use App\UserJob;
use App\Jobstatus;
use App\Notifications\JobUpdated;
use App\Notifications\UserJobUpdated;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class JobController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $userId = User::find(Auth::id())->id;
        $orders = Order::select('orders.*','user_jobs.id as user_jobId')->join("user_jobs",'orders.id','user_jobs.order_id')
        ->where("user_jobs.user_id",$userId)->orderBy("orders.id",'desc')
        ->with('service')->with('addresses')->with("contacts")->with('user')

        ->get();
        return response()->json($orders);
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
        $userId = User::find(Auth::id())->id;
        $orders = Order::select('orders.*','orders.service as jobservice','user_jobs.id as user_jobId')->join("user_jobs",'orders.id','user_jobs.order_id')
        ->where("user_jobs.user_id",$userId)
        ->where("user_jobs.id",$id)->orderBy("orders.id",'desc')
        ->with('service')->with('addresses')->with("contacts")->with('user')

        ->first();
        return response()->json($orders);
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
        $job = UserJob::find($id);
        $job->jobstatus_id = $request->status;
        $job->update();
        if ($request->emails[0] !== $request->emails[1]) {
            foreach ($request->emails as $email) {
                $user = User::where('email', $email)->first();
                if ($user) {
                    return $this->notifyUser($user, $id);
                }
            }
        } else {
            $user = User::where('email', $request->emails[0])->first();
            if ($user) {
                return $this->notifyUser($user, $id);
            }
        }
        return $this->notifyShipper($request->emails, $id);
    }

    public function notifyUser($user, $id)
    {
        $job = UserJob::with('orderDetail', 'jobstatus')->find($id);

        $user->notify(new UserJobUpdated($job));
        return $job;
    }

    public function notifyShipper($emails, $id)
    {
        $job = UserJob::with('orderDetail', 'jobstatus')->find($id);

        if ($emails[0] !== $emails[1]) {
            foreach ($emails as $email) {
                Notification::route('mail', $email)
                    ->notify(new JobUpdated($job));
            }
        } else {
            Notification::route('mail', $emails[0])
                ->notify(new JobUpdated($job));
        }
        return $job;
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
    public function jobStatus()
    {
        return Jobstatus::where('id' ,'<>', 6)->get();
    }
}
