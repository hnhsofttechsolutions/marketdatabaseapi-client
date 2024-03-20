<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{InvestorProfile};

class InvestorProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $investorProfile=InvestorProfile::where('buyer_id',request()->user()->id)->orderBy('id', 'DESC')->get();
        return response()->json(['investorProfile'=>$investorProfile],200);
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
            'type'=> 'required|in:Residential,Office,Retail,Hospitality,Industrial,Light Industrial,Retirement Homes,Student Appartements,Special Real Estate',
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
        ]);

        $investorProfile=new InvestorProfile;
        $investorProfile->buyer_id=request()->user()->id;
        $investorProfile->type=$request->type;
        $investorProfile->portfolio_single_property=$request->portfolio_single_property;
        $investorProfile->object_project=$request->object_project;
        $investorProfile->state=$request->state;
        $investorProfile->city=$request->city;
        $investorProfile->rental_area=$request->rental_area;
        $investorProfile->number_of_apartements=$request->number_of_apartements;
        $investorProfile->rental_income_pa=$request->rental_income_pa;
        $investorProfile->purchase_price=$request->purchase_price;
        $investorProfile->purchase_price_rental_income_pa=$request->purchase_price_rental_income_pa;
        $investorProfile->purchase_price_m2=$request->purchase_price_m2;
        if($investorProfile->save()){
            return response(['investorProfile' => $investorProfile,'message' => 'Investor Profile Created Successfully'], 201);
        }

        return response(['errors' => ['Investor Profile Not Created Please Try Again']], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $investorProfile=InvestorProfile::find($id);
        return response()->json(['investorProfile'=>$investorProfile],200);
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
        $request->validate([
            'type'=> 'required|in:Residential,Office,Retail,Hospitality,Industrial,Light Industrial,Retirement Homes,Student Appartements,Special Real Estate',
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
        ]);

        $investorProfile=InvestorProfile::find($id);
        $investorProfile->buyer_id=request()->user()->id;
        $investorProfile->type=$request->type;
        $investorProfile->portfolio_single_property=$request->portfolio_single_property;
        $investorProfile->object_project=$request->object_project;
        $investorProfile->state=$request->state;
        $investorProfile->city=$request->city;
        $investorProfile->rental_area=$request->rental_area;
        $investorProfile->number_of_apartements=$request->number_of_apartements;
        $investorProfile->rental_income_pa=$request->rental_income_pa;
        $investorProfile->purchase_price=$request->purchase_price;
        $investorProfile->purchase_price_rental_income_pa=$request->purchase_price_rental_income_pa;
        $investorProfile->purchase_price_m2=$request->purchase_price_m2;
        if($investorProfile->save()){
            return response(['investorProfile' => $investorProfile,'message' => 'Investor Profile Updated Successfully'], 201);
        }

        return response(['errors' => ['Investor Profile Not Updated Please Try Again']], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $investorProfile=InvestorProfile::find($id);
        $investorProfile->delete();
        return response()->json(['message' => 'Deleted successfully'],200);
    }
}
