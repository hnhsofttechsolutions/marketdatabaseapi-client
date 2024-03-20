<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,InvestorDetail,InvestorProfile};
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/profile/";
        $buyer=User::with('role','investorDetail','investorProfile')->where('id',request()->user()->id)->first();
        return response()->json(['buyer'=>$buyer,'imagepath'=>$actual_link],200);
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
        //
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
        $data = $request->all();
        $request->validate([
            'email' => "email|required|unique:users,email,$id,id",
            'password' => 'nullable|string|min:8',
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            "image"=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'country_origin'=> 'required|min:3|max:255',
            // 'pursue'=> 'required|min:3|max:255',
            // 'legal_form'=> 'required|min:3|max:255',
            // 'url'=> 'required|min:3|max:255',
            // 'city'=> 'required|min:2|max:255',
            // 'zipcode'=> 'required|min:5|max:7',
            // 'address'=> 'required|min:3|max:255',
            // 'phone_number'=> 'required|min:10|max:20',
            // 'managing_director'=> 'required|min:3|max:255',
            // 'formal'=> 'required|min:3|max:255',
            // 'salutation'=> 'required|min:3|max:255',
            // 'title'=> 'required|min:3|max:255',
            // 'ranking'=> 'required|min:1|max:200',
            // 'Link_purchase_profile'=> 'required|min:3|max:255',
            // 'purchase_contact_person'=> 'required|min:3|max:255',
            // 'email_purchase_request'=> 'required|min:3|max:255',
            // 'residential_real_estate'=> 'required|min:3|max:255',
            // 'office_properties'=> 'required|min:3|max:255',
            // 'retail_shopping_center'=> 'required|min:3|max:255',
            // 'logistics_infrastructure'=> 'required|min:3|max:255',
            // 'light_industrial'=> 'required|min:3|max:255',
            // 'hotels_tourism'=> 'required|min:3|max:255',
            // 'care_health_social_affair'=> 'required|min:3|max:255',
            // 'regional_focus'=> 'required|min:3|max:255',
            // 'germany'=> 'nullable|min:2|max:255',
            // 'switzerland'=> 'nullable|min:3|max:255',
            // 'austria'=> 'nullable|min:2|max:255',
            // 'benelux'=> 'nullable|min:2|max:255',
            // 'eastern_europe'=> 'nullable|min:2|max:255',
            // 'northern_europe'=> 'nullable|min:2|max:255',
            // 'spain'=> 'nullable|min:2|max:255',
            // 'italy'=> 'nullable|min:2|max:255',
            // 'portugal'=> 'nullable|min:2|max:255',
            // 'uk'=> 'nullable|min:2|max:255',
            // 'ireland'=> 'nullable|min:2|max:255',
            // 'investor_type'=> 'required|in:Investment manager,Real estate company',
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
       
        //$token = uniqid();
        $token=rand(10000, 99999);
        $user =User::find($id);
        $user->role_id=3;
        $user->email=$request->email;
        if(!empty($request->password)){
            $user->password=Hash::make($request->password);
        }
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
        //$user->remember_token=$token;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileType = "image-";
            $filename = $fileType.time()."-".rand().".".$file->getClientOriginalExtension();
            $file->storeAs("/public/profile", $filename);
            $user->image = $filename;
        }
        $user->is_active=1;
        if($user->save()){

            // $investorDetail=new InvestorDetail;
            // $investorDetail->buyer_id=$user->id;
            // $investorDetail->country_origin=$request->country_origin;
            // $investorDetail->pursue=$request->pursue;
            // $investorDetail->legal_form=$request->legal_form;
            // $investorDetail->url=$request->url;
            // $investorDetail->city=$request->city;
            // $investorDetail->zipcode=$request->zipcode;
            // $investorDetail->address=$request->address;
            // $investorDetail->phone_number=$request->phone_number;
            // $investorDetail->managing_director=$request->managing_director;
            // $investorDetail->formal=$request->formal;
            // $investorDetail->salutation=$request->salutation;
            // $investorDetail->title=$request->title;
            // $investorDetail->ranking=$request->ranking;
            // $investorDetail->Link_purchase_profile=$request->Link_purchase_profile;
            // $investorDetail->purchase_contact_person=$request->purchase_contact_person;
            // $investorDetail->email_purchase_request=$request->email_purchase_request;
            // $investorDetail->residential_real_estate=$request->residential_real_estate;
            // $investorDetail->office_properties=$request->office_properties;
            // $investorDetail->retail_shopping_center=$request->retail_shopping_center;
            // $investorDetail->logistics_infrastructure=$request->logistics_infrastructure;
            // $investorDetail->light_industrial=$request->light_industrial;
            // $investorDetail->hotels_tourism=$request->hotels_tourism;
            // $investorDetail->care_health_social_affair=$request->care_health_social_affair;
            // $investorDetail->regional_focus=$request->regional_focus;
            // $investorDetail->germany=$request->germany;
            // $investorDetail->switzerland=$request->switzerland;
            // $investorDetail->austria=$request->austria;
            // $investorDetail->benelux=$request->benelux;
            // $investorDetail->eastern_europe=$request->eastern_europe;
            // $investorDetail->northern_europe=$request->northern_europe;
            // $investorDetail->spain=$request->spain;
            // $investorDetail->italy=$request->italy;
            // $investorDetail->portugal=$request->portugal;
            // $investorDetail->uk=$request->uk;
            // $investorDetail->ireland=$request->ireland;
            // $investorDetail->investor_type=$request->investor_type;
            // $investorDetail->save();
            $investorProfile=new InvestorProfile;
            $investorProfile->buyer_id=$user->id;
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
            $investorProfile->save();
            //$accessToken = $user->createToken('myapptoken')->plainTextToken;
            // Mail::send(
            //     'mail.verify-mail',
            //     [
            //         'token'=>$token
            //     ], 
            
            // function ($message) use ($user) {
            //     $message->from(env('MAIL_USERNAME'));
            //     $message->to($user->email);
            //     $message->subject('Verify Email');
            // });
            return response(['buyer' => $user,'message' => 'Updated Successfully'], 201);
        }
        return response(['errors' => ['Your Account Not Updated Please Try Again']], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function passwordChange(Request $request){
        $request->validate([
            "old_password" => "required|min:8|max:50",
            "new_password" => "required|min:8|max:50|required_with:confirm_password|same:confirm_password",
            "confirm_password" => "required|min:8|max:50"
        ]);
        $user = User::where('id',$request->user()->id)->first();
        $hashedPassword = $user->password;
 
        if(Hash::check($request->old_password , $hashedPassword )) {
 
            if (!Hash::check($request->new_password , $hashedPassword)) {
                $users =User::find($request->user()->id);
                $users->password = bcrypt($request->new_password);
                $users->save();
                $response = ['status'=>true,"message" => "Password Changed Successfully"];
                return response($response, 200);
            }else{
                $response = ['status'=>false,"message" => "new password can not be the old password!"];
                return response($response, 422);
            }
 
        }else{
            $response = ['status'=>true,"message" => "old password does not matched"];
            return response($response, 422);
        }

    }
}
