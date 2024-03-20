<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Str;
use Validator;

class SellerBrokerPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::where('is_type','seller_broker')->orderBy('id', 'DESC')->get();
        return response([ 'plans' => $plans, 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $request->validate([
            'name'=>'required|unique:plans|min:3|max:100',
            //'slug'=>'required|min:3|max:100',
            //'stripe_plan'=>'required|unique:plans',
            'price'=>'required|integer',
            'description'=>'required|min:3|max:255',
            'duration'=>'required|integer',
            'period'=>'required|min:3|max:100',
            'offered_property'=>'required|integer',
        ]);
         $plan=new Plan;
         //$category->is_active=1;
         //$attribute->sub_category_id=$request->sub_category_id;
         $plan->name=$request->name;
         $plan->slug=Str::slug($request->name); 
         //$plan->stripe_plan=$request->stripe_plan;
         $plan->price=$request->price;
         $plan->description=$request->description;
         $plan->duration=$request->duration;
         $plan->period=$request->period;
         $plan->offered_property=$request->offered_property;
         $plan->is_type='seller_broker';       
        if($plan->save()){
            return response(['plan' => $plan,'message' => 'created successfully'], 201);
        }
        return response(['message' => 'created Not successfully'], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plans = Plan::where('is_type','seller_broker')->find($id);
        return response(['plan' => $plan, 'message' => 'Retrieved successfully'], 200);
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
    public function update(Request $request,$id)
    {
        $data = $request->all();
        $id = $id;
        //dd($professional);
        $request->validate([
            'name'=>"required|min:3|max:100|unique:plans,stripe_plan,$id,id",
            //'slug'=>'required|min:3|max:100',
            //'stripe_plan'=>"required|unique:plans,stripe_plan,$id,id",
            'price'=>'required|integer',
            'description'=>'required|min:3|max:255',
            'duration'=>'required|integer',
            'period'=>'required|min:3|max:100',
            'offered_property'=>'required|integer',
        ]);
        
        //$shop=new Shop;
        //$category->is_active=1;
        //$shop->slug=Str::slug($request->name);
        //$shop->is_active=1;
        $plan=Plan::find($id);
        $plan->name=$request->name;
        $plan->slug=Str::slug($request->name); 
        //$plan->stripe_plan=$request->stripe_plan;
        $plan->price=$request->price;
        $plan->description=$request->description;
        $plan->duration=$request->duration;
        $plan->period=$request->period;
        $plan->offered_property=$request->offered_property;
        $plan->is_type='seller_broker';   
       if($plan->save()){
           return response(['plan' => $plan,'message' => 'Updated successfully'], 200);
       }
       return response(['message' => 'Updated Not successfully'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan=Plan::find($id);
        $plan->delete();
        return response(['message' => 'Deleted']);
    }
}
