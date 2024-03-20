<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Property,Amenity,ExposeRequest};
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/property/";

       // if(!empty($request->name) OR !empty($request->address) OR !empty($request->property_type) OR !empty($request->start_price) OR !empty($request->end_price)){
            $properties=Property::query();
            // if(!empty($request->name)){
            //     $properties->where('name', 'LIKE', "%{$request->name}%");
            // }
            // if(!empty($request->address)){
            //     $properties->where('address', 'LIKE', "%{$request->address}%"); 
            // }
            if(!empty($request->property_type)){
                $properties->where('type',$request->property_type);
            }
            if(!empty($request->portfolio_single_property)){
                $properties->where('portfolio_single_property', 'LIKE', "%{$request->portfolio_single_property}%"); 
            }
            if(!empty($request->object_project)){
                $properties->where('object_project', 'LIKE', "%{$request->object_project}%"); 
            }
            if(!empty($request->state)){
                $properties->where('state',$request->state);
            }
            if(!empty($request->city)){
                $properties->where('city',$request->city);
            }
            if(!empty($request->rental_area)){
                $properties->where('rental_area', 'LIKE', "%{$request->rental_area}%"); 
            }
            if(!empty($request->number_of_apartements)){
                $properties->where('number_of_apartements',$request->number_of_apartements);
            }
            if(!empty($request->rental_income_pa)){
                $properties->where('rental_income_pa', 'LIKE', "%{$request->rental_income_pa}%"); 
            }
            if(!empty($request->purchase_price)){
                $properties->where('purchase_price',"<=",$request->purchase_price);
            }
            if(!empty($request->purchase_price_rental_income_pa)){
                $properties->where('purchase_price_rental_income_pa',"<=",$request->purchase_price_rental_income_pa);
            }
            if(!empty($request->purchase_price_m2)){
                $properties->where('purchase_price_m2',"<=",$request->purchase_price_m2);
            }
            // if(!empty($request->start_price) && !empty($request->end_price)){
            //     $properties->whereBetween('price', [$request->start_price, $request->end_price]);
            // }
            $properties=$properties->with('amenities','buyer','seller')->orderBy('id', 'DESC')->get();
            return response()->json(['properties'=>$properties,'path'=>$actual_link],200);
        //}
        //return response()->json(['properties'=>null,'path'=>$actual_link],200);
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
        $messages = array(
            'property_id.required' => 'Property is required!',
        );
        $request->validate([
            'property_id'=>'required|integer',
        ],$messages);
        $exposeRequest=ExposeRequest::where('buyer_id',request()->user()->id)->where('property_id',$request->property_id)->first();
        if(empty($exposeRequest)){
            $exposeRequest=new ExposeRequest; 
        }
            
        $exposeRequest->buyer_id=request()->user()->id;
        $exposeRequest->property_id=$request->property_id;
        if($exposeRequest->save()){
            return response(['exposeRequest' => $exposeRequest,'message' => 'Exposed Request Send Successfully'], 201);
        }
        return response(['exposeRequest' => $exposeRequest,'message' => 'Failed To Send Exposed Request'], 201);
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
        $exposeRequest=ExposeRequest::where('buyer_id',request()->user()->id)->where('property_id',$request->id)->first();
        $exposeRequest->delete();
        return response(['message' => 'Deleted']);
    }
}
