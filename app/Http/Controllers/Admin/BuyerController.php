<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,InvestorProfile,InvestorDetail};
use Illuminate\Support\Facades\Hash;
use Mail;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/profile/";
        
        $buyer=User::with('role','investorDetail','investorProfile')->where('role_id',3)->orderBy('id', 'DESC')->get();
        $percentage=[];
        $total=11;
        if(!empty($request->property_type) && !empty($request->portfolio_single_property) && !empty($request->object_project) && !empty($request->state) && !empty($request->city) && !empty($request->rental_area) && !empty($request->number_of_apartements) && !empty($request->rental_income_pa) && !empty($request->purchase_price) && !empty($request->purchase_price_rental_income_pa) && !empty($request->purchase_price_m2)){
            foreach($buyer as $buyerVal){
                $count=0;
                $per=0;
                //if(!empty($buyerVal->investorProfile)){
                    //dd($buyerVal->investorProfile);
                    if($buyerVal->investorProfile()->where('type',$request->property_type)->count()>0){
                        $count++;
                    }
                    if($buyerVal->investorProfile()->where('portfolio_single_property','LIKE',$request->portfolio_single_property)->count()>0){
                        $count++;
                    }

                    if($buyerVal->investorProfile()->where('object_project','LIKE',$request->object_project)->count()>0){
                        $count++;
                    }
                    if($buyerVal->investorProfile()->where('state',$request->state)->count()>0){
                        $count++;
                    }
                    if($buyerVal->investorProfile()->where('city',$request->city)->count()>0){
                        $count++;
                    }
                    if($buyerVal->investorProfile()->where('rental_area','<=',$request->rental_area)->count()>0){
                        $count++;
                    }
                    if($buyerVal->investorProfile()->where('number_of_apartements','<=',$request->number_of_apartements)->count()>0){
                        $count++;
                    }
                    if($buyerVal->investorProfile()->where('rental_income_pa','<=',$request->rental_income_pa)->count()>0){
                        $count++;
                    }
                    if($buyerVal->investorProfile()->where('purchase_price','<=',$request->purchase_price)->count()>0){
                        $count++;
                    }
                    if($buyerVal->investorProfile()->where('purchase_price_rental_income_pa','<=',$request->purchase_price_rental_income_pa)->count()>0){
                        $count++;
                    }
                    if($buyerVal->investorProfile()->where('purchase_price_m2','<=',$request->purchase_price_m2)->count()>0){
                        $count++;
                    }
                    $per=$count/$total;
                    $per=$per*100;
                    //dd($per);
                    $percentage[$buyerVal->id]=number_format((float)$per, 2, '.', '');
                    //$checkProperty=$buyerVal->investorProfile()->where('type',$property_type);
                //}
            }
        }

        //dd($percentage);
        // $buyer=User::query();
        // $numberOfFilter=0;
        // $totalNumberOfFilter=11;
        // if(!empty($request->property_type)){
        //     $property_type=$request->property_type;
        //     $buyer->whereHas('investorProfile', function($q) use($property_type){
        //         $q->where('type', '=', $property_type);
        //     });
        //     $numberOfFilter++;
        // }
        // if(!empty($request->portfolio_single_property)){
        //     $portfolio_single_property=$request->portfolio_single_property;
        //     $buyer->whereHas('investorProfile', function($q) use($portfolio_single_property){
        //         $q->where('portfolio_single_property', 'LIKE', "%{$portfolio_single_property}%");
        //     });
        //     $numberOfFilter++;
        // }
        // if(!empty($request->object_project)){
        //     $object_project=$request->object_project;
        //     $buyer->whereHas('investorProfile', function($q) use($object_project){
        //         $q->where('object_project', 'LIKE', "%{$object_project}%");
        //     });
        //     $numberOfFilter++;
        // }
        // if(!empty($request->state)){
        //     $state=$request->state;
        //     $buyer->whereHas('investorProfile', function($q) use($state){
        //         $q->where('state', '=', $state);
        //     });
        //     $numberOfFilter++;
        // }
        // if(!empty($request->city)){
        //     $city=$request->city;
        //     $buyer->whereHas('investorProfile', function($q) use($city){
        //         $q->where('city', '=', $city);
        //     });
        //     $numberOfFilter++;
        // }
        // if(!empty($request->rental_area)){
        //     $rental_area=$request->rental_area;
        //     $buyer->whereHas('investorProfile', function($q) use($rental_area){
        //         $q->where('rental_area', '<=', "%{$rental_area}%");
        //     });
        //     $numberOfFilter++;
        // }
        // if(!empty($request->number_of_apartements)){
        //     $number_of_apartements=$request->number_of_apartements;
        //     $buyer->whereHas('investorProfile', function($q) use($number_of_apartements){
        //         $q->where('number_of_apartements', '<=', $number_of_apartements);
        //     });
        //     $numberOfFilter++;
        // }
        // if(!empty($request->rental_income_pa)){
        //     $rental_income_pa=$request->rental_income_pa;
        //     $buyer->whereHas('investorProfile', function($q) use($rental_income_pa){
        //         $q->where('rental_income_pa', '<=', "%{$rental_income_pa}%");
        //     });
        //     $numberOfFilter++;
        // }
        // if(!empty($request->purchase_price)){
        //     $purchase_price=$request->purchase_price;
        //     $buyer->whereHas('investorProfile', function($q) use($purchase_price){
        //         $q->where('purchase_price', '<=', $purchase_price);
        //     });
        //     $numberOfFilter++;
        // }
        // if(!empty($request->purchase_price_rental_income_pa)){
        //     $purchase_price_rental_income_pa=$request->purchase_price_rental_income_pa;
        //     $buyer->whereHas('investorProfile', function($q) use($purchase_price_rental_income_pa){
        //         $q->where('purchase_price_rental_income_pa', '<=', $purchase_price_rental_income_pa);
        //     });
        //     $numberOfFilter++;
        // }
        // if(!empty($request->purchase_price_m2)){
        //     $purchase_price_m2=$request->purchase_price_m2;
        //     $buyer->whereHas('investorProfile', function($q) use($purchase_price_m2){
        //         $q->where('purchase_price_m2', '<=', $purchase_price_m2);
        //     });
        //     $numberOfFilter++;
        // }
       
        // $buyer=$buyer->with('role','investorDetail','investorProfile')->where('role_id',3)->orderBy('id', 'DESC')->get();
        //$per=0;
        // if($numberOfFilter>0 && !$buyer->isEmpty()){
        //     $per=$numberOfFilter/$totalNumberOfFilter;
        //     $per=$per*100;
        // } 
        // $per=number_format((float)$per, 2, '.', '');
        return response()->json(['buyer'=>$buyer,'imagepath'=>$actual_link,'percentage'=>$percentage],200);
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
            'email' => 'email|required|unique:users',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            //'is_broker' => 'required|boolean',
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
            "image"=>'required|image|mimes:jpeg,png,jpg|max:2048',
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
        $user = new User;
        $user->role_id=3;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
        //$user->is_broker=$request->is_broker;
        //$user->last_name=$request->last_name;
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
            Mail::send(
                'mail.credentail-mail',
                [
                    'email'=>$request->email,
                    'password'=>$request->password
                ], 
            
            function ($message) use ($user) {
                $message->from(env('MAIL_USERNAME'));
                $message->to($user->email);
                $message->subject('Your Account Credentail');
            });
            return response(['user' => $user,'message' => 'Seller Created Successfully'], 201);
        }
        return response(['errors' => ['Seller Not Created Please Try Again']], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/profile/";
        $buyer=User::with('role','investorDetail','investorProfile','property')->where('role_id',3)->find($id);
        return response()->json(['buyer'=>$buyer,'imagepath'=>$actual_link],200);
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
            //'is_broker' => 'required|boolean',
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
            "image"=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
        //$user->is_broker=$request->is_broker;
        //$user->last_name=$request->last_name;
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

            //$accessToken = $user->createToken('myapptoken')->plainTextToken;

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

            if(!empty($request->password)){
                Mail::send(
                    'mail.credentail-mail',
                    [
                        'email'=>$request->email,
                        'password'=>$request->password
                    ], 
                
                function ($message) use ($user) {
                    $message->from(env('MAIL_USERNAME'));
                    $message->to($user->email);
                    $message->subject('Your Account Credentail');
                });
            }
            return response(['seller' => $user,'message' => 'Updated Successfully'], 201);
        }
        return response(['errors' => ['Your Account Not Updated Please Try Again']], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        $messages = array(
            'id.required' => 'User is required!',
        );
        $request->validate([
            'is_active' => 'required',
            'id' => 'required|integer|exists:users,id', 
        ],$messages);
        $type="Buyer";
        if($request->is_broker){
            $type="Broker";
        }
        $message=$type." Deactive Now";
        if($request->is_active==true){
            $message=$type." Active Now";
        }
        $user=User::where('id',$request->id)->where('role_id',3)->first();
        $user->is_active=$request->is_active==true?1:0;
       if($user->save()){
           return response(['buyer' => $user,'message' => $message], 200);
       }
       return response(['message' => 'Updated Not successfully'], 422);
    }
}
