<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Property,Amenity,ExposeRequest};

class ExposeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/property/";
        $properties=Property::with('amenities','buyer')->has('buyer')->where('seller_id',request()->user()->id)->orderBy('id', 'DESC')->get();
        return response()->json(['properties'=>$properties,'path'=>$actual_link],200);
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
            'buyer_id'=>'required|integer',
            'property_id'=>'required|integer',
            'status'=>'required|in:pending,accepted,cancelled',
        ],$messages);
        $exposeRequest=ExposeRequest::where('property_id',$request->property_id)->where('buyer_id',$request->buyer_id)->first();
        if(empty($exposeRequest)){
            return response(['message' => 'Property Not found'], 400);
        }
            
        $exposeRequest->property_id=$request->property_id;
        $exposeRequest->status=$request->status;
        if($exposeRequest->save()){
            return response(['exposeRequest' => $exposeRequest,'message' => 'Exposed Request Status Changed Successfully'], 201);
        }
        return response(['exposeRequest' => $exposeRequest,'message' => 'Failed Pleased Try Agnain'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/property/";
        $property=Property::with('amenities','buyer')->has('buyer')->where('seller_id',request()->user()->id)->find($id);
        return response()->json(['property'=>$property,'path'=>$actual_link],200);
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
