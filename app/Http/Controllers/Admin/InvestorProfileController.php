<?php

namespace App\Http\Controllers\Admin;

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
        $investorProfile=InvestorProfile::with('buyer')->orderBy('id', 'DESC')->get();
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $investorProfile=InvestorProfile::with('buyer')->find($id);
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
            'status'=> 'required|in:pending,accepted,cancelled',
            
        ]);

        $investorProfile=InvestorProfile::find($id);
        $investorProfile->status=$request->status;
        if($investorProfile->save()){
            return response(['investorProfile' => $investorProfile,'message' => 'Investor Profile Status Updated Successfully'], 201);
        }

        return response(['errors' => ['Investor Profile Status  Not Updated Please Try Again']], 400);
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
