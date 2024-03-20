<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Property,Amenity};
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/property/";
        //$properties=Property::with('amenities','seller','buyer')->get();
            $numberOfFilter=0;
            $properties=Property::query();
            // if(!empty($request->name)){
            //     $properties->where('name', 'LIKE', "%{$request->name}%");
            // }
            // if(!empty($request->address)){
            //     $properties->where('address', 'LIKE', "%{$request->address}%"); 
            // }
            if(!empty($request->property_type)){
                $properties->where('type',$request->property_type);
                $numberOfFilter++;
            }
            if(!empty($request->portfolio_single_property)){
                $properties->where('portfolio_single_property', 'LIKE', "%{$request->portfolio_single_property}%"); 
                $numberOfFilter++;
            }
            if(!empty($request->object_project)){
                $properties->where('object_project', 'LIKE', "%{$request->object_project}%"); 
                $numberOfFilter++;
            }
            if(!empty($request->state)){
                $properties->where('state',$request->state);
                $numberOfFilter++;
            }
            if(!empty($request->city)){
                $properties->where('city',$request->city);
                $numberOfFilter++;
            }
            if(!empty($request->rental_area)){
                $properties->where('rental_area', '<=', "%{$request->rental_area}%"); 
                $numberOfFilter++;
            }
            if(!empty($request->number_of_apartements)){
                $properties->where('number_of_apartements','<=',$request->number_of_apartements);
                $numberOfFilter++;
            }
            if(!empty($request->rental_income_pa)){
                $properties->where('rental_income_pa', '<=', "%{$request->rental_income_pa}%"); 
                $numberOfFilter++;
            }
            if(!empty($request->purchase_price)){
                $properties->where('purchase_price',"<=",$request->purchase_price);
                $numberOfFilter++;
            }
            if(!empty($request->purchase_price_rental_income_pa)){
                $properties->where('purchase_price_rental_income_pa',"<=",$request->purchase_price_rental_income_pa);
                $numberOfFilter++;
            }
            if(!empty($request->purchase_price_m2)){
                $properties->where('purchase_price_m2',"<=",$request->purchase_price_m2);
                $numberOfFilter++;
            }
            // if(!empty($request->start_price) && !empty($request->end_price)){
            //     $properties->whereBetween('price', [$request->start_price, $request->end_price]);
            // }
            $properties=$properties->with('amenities','buyer','seller')->orderBy('id', 'DESC')->get();
            return response()->json(['properties'=>$properties,'numberOfFilter'=>$numberOfFilter,'path'=>$actual_link],200);
            //return response()->json(['properties'=>$properties,'path'=>$actual_link],200);
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
            'seller_id.required' => 'Seller is required!',
        );
        $data = $request->all();
        $request->validate([
            //'name' => 'required|unique:properties',
            'seller_id' => 'required|integer',
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
            'purchase_price_rental_income_pa'=> 'required',
            'purchase_price_m2'=> 'required',
            "image"=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
            "video"=>'nullable|mimes:mp4,ogx,oga,ogv,ogg,webm',
            // 'amenity'=> 'required|array',
            // 'amenity.*'  => 'required|string|min:2|max:100',
        ],$messages);

        $property=new Property;
        // $property->name=$request->name;
        // $property->slug=Str::slug($request->name); 
        $property->seller_id=$request->seller_id;
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
        $property=Property::with('amenities','seller','buyer')->find($id);
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
        $messages = array(
            'seller_id.required' => 'Seller is required!',
        );
        $data = $request->all();
        $request->validate([
            //'name' => "required|unique:properties,name,$id,id",
            'seller_id' => 'required|integer',
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
            'purchase_price_rental_income_pa'=> 'required',
            'purchase_price_m2'=> 'required',
            "image"=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
            "video"=>'nullable|mimes:mp4,ogx,oga,ogv,ogg,webm',
            // 'amenity'=> 'required|array',
            // 'amenity.*'  => 'required|string|min:2|max:100',
        ],$messages);

        $property=Property::find($id);
        // $property->name=$request->name;
        // $property->slug=Str::slug($request->name); 
        $property->seller_id=$request->seller_id;
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
        $property=Property::with('amenities')->find($id);
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
        $property=Property::where('id',$request->id)->first();
        $property->is_active=$request->is_active==true?1:0;
       if($property->save()){
           return response(['property' => $property,'message' => $message], 200);
       }
       return response(['message' => 'Updated Not successfully'], 422);
    }
}
