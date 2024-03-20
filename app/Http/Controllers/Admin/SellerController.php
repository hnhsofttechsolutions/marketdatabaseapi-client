<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};
use Illuminate\Support\Facades\Hash;
use Mail;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/profile/";
        $seller=User::with('role')->where('role_id',2)->orderBy('id', 'DESC')->get();
        return response()->json(['seller'=>$seller,'imagepath'=>$actual_link],200);
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
            'is_broker' => 'required|boolean',
            //"image"=>'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
       
        //$token = uniqid();
        $token=rand(10000, 99999);
        $user = new User;
        $user->role_id=2;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
        $user->is_broker=$request->is_broker;
        //$user->last_name=$request->last_name;
        //$user->remember_token=$token;
        // if($request->hasFile('image')){
        //     $file = $request->file('image');
        //     $fileType = "image-";
        //     $filename = $fileType.time()."-".rand().".".$file->getClientOriginalExtension();
        //     $file->storeAs("/public/profile", $filename);
        //     $user->image = $filename;
        // }
        $user->is_active=1;
        if($user->save()){

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
        $seller=User::with('role')->where('role_id',2)->find($id);
        return response()->json(['seller'=>$seller,'imagepath'=>$actual_link],200);
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
            'is_broker' => 'required|boolean',
            //"image"=>'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
       
        //$token = uniqid();
        $token=rand(10000, 99999);
        $user =User::find($id);
        $user->role_id=2;
        $user->email=$request->email;
        if(!empty($request->password)){
            $user->password=Hash::make($request->password);
        }
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
        $user->is_broker=$request->is_broker;
        //$user->last_name=$request->last_name;
        //$user->remember_token=$token;
        // if($request->hasFile('image')){
        //     $file = $request->file('image');
        //     $fileType = "image-";
        //     $filename = $fileType.time()."-".rand().".".$file->getClientOriginalExtension();
        //     $file->storeAs("/public/profile", $filename);
        //     $user->image = $filename;
        // }
        $user->is_active=1;
        if($user->save()){

            //$accessToken = $user->createToken('myapptoken')->plainTextToken;
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
        $user=User::find($id);
        $user->delete();
        return response(['message' => 'Deleted']);
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
        $type="Seller";
        if($request->is_broker){
            $type="Broker";
        }
        $message=$type." Deactive Now";
        if($request->is_active==true){
            $message=$type." Active Now";
        }
        $user=User::where('id',$request->id)->where('role_id',2)->first();
        $user->is_active=$request->is_active==true?1:0;
       if($user->save()){
           return response(['seller' => $user,'message' => $message], 200);
       }
       return response(['message' => 'Updated Not successfully'], 422);
    }
}
