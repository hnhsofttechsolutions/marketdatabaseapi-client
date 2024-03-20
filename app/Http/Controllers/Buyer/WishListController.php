<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Property,Amenity,WishList};

class WishListController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id=request()->user()->id;
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/property/";
        $wishListPropertyId=WishList::where('buyer_id',request()->user()->id)->pluck('property_id')->toArray();
        //dd($wishListPropertyId);
        $properties=Property::with('amenities','seller')->whereIn('id',$wishListPropertyId)->get();
         //$user=User::with('property.amenities','property.seller')->where('id',$user_id)->first();
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
            'property_id'=>'required|integer',
        ],$messages);
        $wishList=WishList::where('property_id',$request->property_id)->where('buyer_id',request()->user()->id)->first();
        if(empty($wishList)){
            $wishList=new WishList;
        }
        $wishList->buyer_id=request()->user()->id;
        $wishList->property_id=$request->property_id;
        if($wishList->save()){
            return response(['wishList' => $wishList,'message' => 'Exposed Request Status Changed Successfully'], 201);
        }
        return response(['wishList' => $wishList,'message' => 'Failed Pleased Try Agnain'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/property/";
        $property=Property::with('amenities','seller')->find($id);
        return response()->json(['property'=>$property,'path'=>$actual_link],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
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

        $wishList=WishList::where('property_id',$id)->where('buyer_id',request()->user()->id)->first();
        $wishList->delete();
        return response(['message' => 'Deleted']);
    }
}
