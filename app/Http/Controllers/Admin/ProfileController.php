<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/profile/";
        $admin=User::with('role')->where('id',request()->user()->id)->first();
        return response()->json(['admin'=>$admin,'imagepath'=>$actual_link],200);
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
        ]);
       
        //$token = uniqid();
        $token=rand(10000, 99999);
        $user =User::find($id);
        $user->role_id=1;
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
            return response(['admin' => $user,'message' => 'Updated Successfully'], 201);
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
