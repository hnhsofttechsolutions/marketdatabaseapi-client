<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Property,Amenity};
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/property/";
        $properties=Property::with('amenities','buyer')->where('seller_id',request()->user()->id)->orderBy('id', 'DESC')->get();
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
       
        $data = $request->all();
        $request->validate([
            // 'name' => 'required|unique:properties',
            // 'price' => 'required|integer',
            // 'address' => 'required|min:3|max:255',
            // 'area'=> 'required|min:3|max:255',
            // 'description'=> 'nullable|min:3|max:6000',
            // 'property_id'=> 'required|min:3|max:100',
            'type'=> 'required|in:Residential,Office,Retail,Hospitality,Industrial,Light Industrial,Retirement Homes,Student Appartements,Special Real Estate',
            // 'status' => 'required|min:3|max:100',
            // 'room' => 'required|integer',
            // 'bedroom' => 'required|integer',
            // 'bath' => 'required|integer',
            // 'garage' => 'required|integer',
            // 'year_Built' => 'required|date',
            'portfolio_single_property'=> 'required|min:3|max:255',
            'object_project'=> 'required|min:3|max:255',
            'state'=> 'required|min:2|max:255',
            'city'=> 'required|min:2|max:255',
            'rental_area'=> 'required|integer',
            'number_of_apartements'=>'nullable|integer',
            'rental_income_pa'=> 'required|integer',
            'purchase_price'=> 'required|integer',
            'purchase_price_rental_income_pa'=> 'required|integer',
            'purchase_price_m2'=> 'required|integer',
            "image"=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
            "video"=>'nullable|mimes:mp4,ogx,oga,ogv,ogg,webm',
            // 'amenity'=> 'required|array',
            // 'amenity.*'  => 'required|string|min:2|max:100',
        ]);

        $property=new Property;
        // $property->name=$request->name;
        // $property->slug=Str::slug($request->name); 
        $property->seller_id=request()->user()->id;
        // $property->price=$request->price;
        // $property->address=$request->address;
        // $property->area=$request->area;
        // $property->description=$request->description;
        // $property->property_id=$request->property_id;
        $property->type=$request->type;
        // $property->status=$request->status;
        // $property->room=$request->room;
        // $property->bedroom=$request->bedroom;
        // $property->bath=$request->bath;
        // $property->garage=$request->garage;
        // $property->year_Built=$request->year_Built;
        $property->portfolio_single_property=$request->portfolio_single_property;
        $property->object_project=$request->object_project;
        $property->state=$request->state;
        $property->city=$request->city;
        $property->rental_area=$request->rental_area;
        $property->number_of_apartements=$request->number_of_apartements;
        $property->rental_income_pa=$request->rental_income_pa;
        $property->purchase_price=$request->purchase_price;
        $property->purchase_price_rental_income_pa=$request->purchase_price_rental_income_pa;
        $property->purchase_price_m2=$request->purchase_price_m2;
        $property->is_active=1;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileType = "image-";
            $filename = $fileType.time()."-".rand().".".$file->getClientOriginalExtension();
            $file->storeAs("/public/property", $filename);
            $property->image = $filename;
        }
        if($request->hasFile('video')){
            $file = $request->file('video');
            $fileType = "videa-";
            $filename = $fileType.time()."-".rand().".".$file->getClientOriginalExtension();
            $file->storeAs("/public/property", $filename);
            $property->video = $filename;
        }
        if($property->save()){

            // if(!empty($request->amenity)){
            //     for($i = 0; $i<count($request->amenity); $i++)
            //     {
            //         $amenity=new Amenity;
            //         $amenity->property_id=$property->id;
            //         $amenity->name=$request->amenity[$i]??"";
            //         $amenity->save();
            //     }
            // }
            return response(['property' => $property,'message' => 'Property Created Successfully'], 201);
        }

        return response(['errors' => ['Property Not Created Please Try Again']], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/property/";
        $property=Property::with('amenities','buyer')->where('seller_id',request()->user()->id)->find($id);
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
       
        $data = $request->all();
        $request->validate([
            // 'name' => "required|unique:properties,name,$id,id",
            // 'price' => 'required|integer',
            // 'address' => 'required|min:3|max:255',
            // 'area'=> 'required|min:3|max:255',
            // 'description'=> 'nullable|min:3|max:6000',
            // 'property_id'=> 'required|min:3|max:100',
            'type'=> 'required|in:Residential,Office,Retail,Hospitality,Industrial,Light Industrial,Retirement Homes,Student Appartements,Special Real Estate',
            // 'status' => 'required|min:3|max:100',
            // 'room' => 'required|integer',
            // 'bedroom' => 'required|integer',
            // 'bath' => 'required|integer',
            // 'garage' => 'required|integer',
            // 'year_Built' => 'required|date',
            'portfolio_single_property'=> 'required|min:3|max:255',
            'object_project'=> 'required|min:3|max:255',
            'state'=> 'required|min:2|max:255',
            'city'=> 'required|min:2|max:255',
            'rental_area'=> 'required|integer',
            'number_of_apartements'=>'nullable|integer',
            'rental_income_pa'=> 'required|integer',
            'purchase_price'=> 'required|integer',
            'purchase_price_rental_income_pa'=> 'required|integer',
            'purchase_price_m2'=> 'required|integer',
            "image"=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
            "video"=>'nullable|mimes:mp4,ogx,oga,ogv,ogg,webm',
            // 'amenity'=> 'required|array',
            // 'amenity.*'  => 'required|string|min:2|max:100',
        ]);

        $property=Property::find($id);
        // $property->name=$request->name;
        // $property->slug=Str::slug($request->name); 
        $property->seller_id=request()->user()->id;
        //$property->price=$request->price;
        // $property->address=$request->address;
        // $property->area=$request->area;
        // $property->description=$request->description;
        // $property->property_id=$request->property_id;
        $property->type=$request->type;
        // $property->status=$request->status;
        // $property->room=$request->room;
        // $property->bedroom=$request->bedroom;
        // $property->bath=$request->bath;
        // $property->garage=$request->garage;
        // $property->year_Built=$request->year_Built;
        $property->portfolio_single_property=$request->portfolio_single_property;
        $property->object_project=$request->object_project;
        $property->state=$request->state;
        $property->city=$request->city;
        $property->rental_area=$request->rental_area;
        $property->number_of_apartements=$request->number_of_apartements;
        $property->rental_income_pa=$request->rental_income_pa;
        $property->purchase_price=$request->purchase_price;
        $property->purchase_price_rental_income_pa=$request->purchase_price_rental_income_pa;
        $property->purchase_price_m2=$request->purchase_price_m2;
        $property->is_active=1;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileType = "image-";
            $filename = $fileType.time()."-".rand().".".$file->getClientOriginalExtension();
            $file->storeAs("/public/property", $filename);
            $property->image = $filename;
        }
        if($request->hasFile('video')){
            $file = $request->file('video');
            $fileType = "videa-";
            $filename = $fileType.time()."-".rand().".".$file->getClientOriginalExtension();
            $file->storeAs("/public/property", $filename);
            $property->video = $filename;
        }
        if($property->save()){

            // if(!empty($request->amenity)){
            //     $amenity=Amenity::where('property_id',$property->id)->delete();
            //     for($i = 0; $i<count($request->amenity); $i++)
            //     {
            //         $amenity=new Amenity;
            //         $amenity->property_id=$property->id;
            //         $amenity->name=$request->amenity[$i]??"";
            //         $amenity->save();
            //     }
            // }
            return response(['property' => $property,'message' => 'Property Updated Successfully'], 201);
        }

        return response(['errors' => ['Property Not Updated Please Try Again']], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property=Property::with('amenities')->where('seller_id',request()->user()->id)->find($id);
        $property->delete();
        return response(['message' => 'Deleted']);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        $messages = array(
            'id.required' => 'Property is required!',
        );
        $request->validate([
            'is_active' => 'required',
            'id' => 'required|integer|exists:properties,id', 
        ],$messages);
        
        $message="Property Deactive Now";
        if($request->is_active==true){
            $message="Property Active Now";
        }
        $property=Property::where('id',$request->id)->where('seller_id',request()->user()->id)->first();
        $property->is_active=$request->is_active==true?1:0;
       if($property->save()){
           return response(['property' => $property,'message' => $message], 200);
       }
       return response(['message' => 'Updated Not successfully'], 422);
    }
}
