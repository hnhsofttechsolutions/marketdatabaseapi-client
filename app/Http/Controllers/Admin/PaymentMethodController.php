<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;
use Validator;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethod = PaymentMethod::where('is_active','1')->orderBy('id', 'DESC')->get();
        return response([ 'paymentMethod' => $paymentMethod, 'message' => 'Retrieved successfully'], 200);
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
         $data = $request->all();   
         $request->validate([  'name' => "required|min:3|max:200|unique:payment_methods",
            'public_key' => 'required|min:3|max:200',
            'secret_key' => 'required|min:3|max:200',
        ]);    
         $paymentMethod=new PaymentMethod;
         $paymentMethod->is_active=1;
         $paymentMethod->name=$request->name;
         $paymentMethod->slug=Str::slug($request->name); 
         $paymentMethod->public_key=$request->public_key;
         $paymentMethod->secret_key=$request->secret_key;
       
        if($paymentMethod->save()){
            return response(['paymentMethod' => $paymentMethod,'message' => 'created successfully'], 201);
        }
        return response(['message' => 'created Not successfully'], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentMethod = PaymentMethod::where('is_active','1')->find($id);
        return response(['paymentMethod' => $paymentMethod, 'message' => 'Retrieved successfully'], 200);
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
    public function update(Request $request, $id)
    {
        $data = $request->all();   
         $request->validate([  'name' => "required|min:3|max:200|unique:payment_methods,name,$id,id",
            'public_key' => 'required|min:3|max:200',
            'secret_key' => 'required|min:3|max:200',
        ]);    
         $paymentMethod=PaymentMethod::find($id);
         $paymentMethod->is_active=1;
         $paymentMethod->name=$request->name;
         $paymentMethod->slug=Str::slug($request->name); 
         $paymentMethod->public_key=$request->public_key;
         $paymentMethod->secret_key=$request->secret_key;
       
        if($paymentMethod->save()){
            return response(['paymentMethod' => $paymentMethod,'message' => 'updated successfully'], 201);
        }
        return response(['message' => 'updated Not successfully'], 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paymentMethod=PaymentMethod::find($id);
        $paymentMethod->delete();
        return response(['message' => 'Deleted']);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        $messages = array(
            'id.required' => 'Payment method is required!',
        );
        $request->validate([
            'is_active' => 'required',
            'id' => 'required|integer|exists:payment_methods,id', 
        ],$messages);
        
        $message="Payment method Deactive Now";
        if($request->is_active==true){
            $message="Payment method Active Now";
        }
        $paymentMethod=PaymentMethod::find($request->id);
        $paymentMethod->is_active=$request->is_active==true?1:0;
       if($paymentMethod->save()){
           return response(['paymentMethod' => $paymentMethod,'message' => $message], 200);
       }
       return response(['message' => 'Updated Not successfully'], 422);
    }
}
