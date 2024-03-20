<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Plan,SubscriptionPlan,PaymentMethod};
use Illuminate\Support\Str;
use Validator;
use Stripe;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = request()->user()->id;
        $subscription = SubscriptionPlan::with('plan')->where('user_id',$user_id)->first();
        return response([ 'subscription' => $subscription, 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|integer',
            "source"=>'required',
        ]);
        $plan = Plan::find($request->plan_id);
        // dd($request->token);
        $paymentMethod = PaymentMethod::where('is_active','1')->where('slug','stripe')->first();
        $seceretKey =$paymentMethod->secret_key;
        if(!empty($plan)){
            $stripe = new Stripe\StripeClient($seceretKey);
            
            //   dd($stripe);


            $stripe->charges->create([
                'amount' => $plan->price * 100,
                'currency' => 'usd',
                'source' => $request->source,
                'description' => 'My First Test Charge (created for API docs)',
            ]);

        

            //dd($plan);
            //dd($plan);
            $newDateTime =  now()->format('Y-m-d');
            if($plan->period=="days"){
                $newDateTime = Carbon::now()->addDays($plan->duration);
            }else if($plan->period=="weeks"){
                $days = $plan->duration * 7;
                // dd($days);
                $newDateTime = Carbon::now()->addDays($days);            
            }else if($plan->period=="months"){
                $newDateTime = Carbon::now()->addMonths($plan->duration);            
            }else if($plan->period=="years"){
                $newDateTime = Carbon::now()->addYears($plan->duration);
                            
            }
            $date = $newDateTime->format('Y-m-d');
            // dd($date);
            $user_id = request()->user()->id;
            $subscription = SubscriptionPlan::where('user_id',$user_id)->first();
            $start_date = Carbon::now()->format('Y-m-d');
            if($subscription==null){
                $subscription = new SubscriptionPlan;
                $subscription->user_id = $user_id;
            }
            $subscription->start_date = $start_date;
            $subscription->expiry_date = $date;
            $subscription->plan_id = $plan->id;
            $subscription->save();
            return response()->json(['status' => true, 'message' => "Payment Successfully Sent",'subscripton'=>$subscription]);
        }

        return response()->json(['status' => false, 'message' => "Payment Failed Pleased Try Again"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
