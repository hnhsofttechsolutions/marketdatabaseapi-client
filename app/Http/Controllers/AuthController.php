<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Validator;
use Mail;
use Carbon\Carbon;
Use Auth;

class AuthController extends Controller
{
    public function sellerRegister(Request $request)
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

            $accessToken = $user->createToken('myapptoken')->plainTextToken;
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
            return response(['user' => $user, 'accessToken' => $accessToken,'message' => 'Email Sent On Your Email Please Verify Your Email Then Login'], 201);
        }
        return response(['errors' => ['Your Account Not Register Please Try Again']], 400);
    }

    public function buyerRegister(Request $request)
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
        $user->role_id=3;
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

            $accessToken = $user->createToken('myapptoken')->plainTextToken;
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
            return response(['user' => $user, 'accessToken' => $accessToken,'message' => 'Email Sent On Your Email Please Verify Your Email Then Login'], 201);
        }
        return response(['errors' => ['Your Account Not Register Please Try Again']], 400);
    }

    public function adminLogin(Request $request)
    {
        $messages=array(
                "email.exists"=>"Email Does Not Exists",
            );
        $request->validate([
                        //"role_id"=>"required",
                        "email"=>"required|exists:users,email",
                        'password' => 'required|min:8',
                    ],$messages);
                    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/profile/";
        // if ($validator->fails())
        // {
        //     return response(['errors'=>$validator->errors()->all()], 422);
        // }
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 1,
            //'is_active' => 1,
        ];

        if (!auth::guard('admin')->attempt($credentials)) {
            return response(['errors' => ['Invalid Password']], 400);
        }
        //$accessToken = auth::guard('admin')->user()->createToken('authToken')->accessToken;
        $token = auth::guard('admin')->user()->createToken('myapptoken')->plainTextToken;
        $user = User::with('role')->where('id',auth::guard('admin')->user()->id)->first();
        if(auth::guard('admin')->user()->is_active==0){
            return response(['errors' => ['Your Account Deactive Now Please Active Your']], 400);
        }
        return response(['admin' => $user, 'accessToken' => $token,'imagepath'=>$actual_link]);
    }

    public function sellerLogin(Request $request)
    {
        $messages=array(
                "email.exists"=>"Email Does Not Exists",
            );
            $request->validate([
                        //"role_id"=>"required",
                        "email"=>"required|exists:users,email",
                        'password' => 'required|min:8',
                    ],$messages);
        // if ($validator->fails())
        // {
        //     return response(['errors'=>$validator->errors()->all()], 422);
        // }
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/profile/";
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 2,
            //'is_active' => 1,
        ];

        if (!auth::guard('user')->attempt($credentials)) {
            return response(['errors' => ['Invalid Password']], 400);
        }
        //$accessToken = auth::guard('admin')->user()->createToken('authToken')->accessToken;
        $token = auth::guard('user')->user()->createToken('myapptoken')->plainTextToken;
        $user = User::with('role')->where('id',auth::guard('user')->user()->id)->first();
        if(auth::guard('user')->user()->is_active==0){
            return response(['errors' => ['Your Account Deactive Now Please Active Your']], 400);
        }
        return response(['seller' => $user, 'accessToken' => $token,'imagepath'=>$actual_link]);
    }

    public function buyerLogin(Request $request)
    {
        $messages=array(
                "email.exists"=>"Email Does Not Exists",
            );
            $request->validate([
                        //"role_id"=>"required",
                        "email"=>"required|exists:users,email",
                        'password' => 'required|min:8',
                    ],$messages);
        // if ($validator->fails())
        // {
        //     return response(['errors'=>$validator->errors()->all()], 422);
        // }
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/storage/profile/";
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 3,
            //'is_active' => 1,
        ];

        if (!auth::guard('user')->attempt($credentials)) {
            return response(['errors' => ['Invalid Password']], 400);
        }
        //$accessToken = auth::guard('admin')->user()->createToken('authToken')->accessToken;
        $token = auth::guard('user')->user()->createToken('myapptoken')->plainTextToken;
        $user = User::with('role')->where('id',auth::guard('user')->user()->id)->first();
        if(auth::guard('user')->user()->is_active==0){
            return response(['errors' => ['Your Account Deactive Now Please Active Your']], 400);
        }
        return response(['buyer' => $user, 'accessToken' => $token,'imagepath'=>$actual_link]);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['status'=>true,'message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
   
     //These functions are used to forget password admin,subadmin,agent
     public function forgetpassword(Request $req)
     {
        
        $req->validate([
            'email' => 'required|email'
        ]);

         $query = User::where('email',$req->email)->where('is_active',1)->first();
          //dd($query);
         if($query == null)
         {
             return response(['status' => false, 'errors' => ['Email does not exist OR your account deactive']],422);
         }        
         else{
             $token = uniqid();
             $query->remember_token = $token;
             $query->save();
             Mail::send(
                 'mail.forget-mail',
                 [
                     'token'=>$token,
                     'role_id'=>$query->role_id
                     //'last_name'=>$query->last_name
                 ], 
             
             function ($message) use ($query) {
                 $message->from(env('MAIL_USERNAME'));
                 $message->to($query->email);
                 $message->subject('Forget Password');
             });
             return response(['status' => true, 'message' => 'Token send to your email'],200);
 
         }
 
     }
     //These functions are used to check user is valid
     public function token_check($token)
     {
        //  $req->validate([
        //      'token' => 'required'
        //  ]);
         $query = User::where('remember_token',$token)->where('is_active',1)->first();
         if($query == null)
         {
             return response(['status' => false, 'errors' => ['Token not match']],422);
         }
         else{
            $query->is_active=1;
            //$query->remember_token=null;
            $query->save();
             return response(['status' => true, 'message' => 'token verify Succesfully','user'=>$query],200);
         }
 
     }
     //These functions are used to reset password admin,subadmin,agent
     public function reset_password(Request $req)
     {
    
        $req->validate([
            'token'=>'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

         $user = User::with('role')->where('remember_token','=',$req->token)->where('is_active',1)->first();  
         if($user == null)
         {
             return response(['status' => false, 'errors' => ['Token not match']],422);
         }
         else
         {
             $user->password = Hash::make($req->password);
             $user->remember_token = null;
             $save = $user->save();
             if($save)
             {
                 return response(['status' => true, 'message' => 'Success','role'=>$user->role->name],200);
             }
             else
             {
                 return response(['status' => false, 'errors' => ['Failed']],422);
             }
         }
 
     }

    public function passwordChange(Request $request){
        $controlls = $request->all();
        $id=$request->id;
        $request->validate([
            "old_password" => "required",
            "new_password" => "required|required_with:confirm_password|same:confirm_password",
            "confirm_password" => "required"
        ]);

        // $validator = Validator::make($controlls, $rules);
        // if ($validator->fails()) {
        //     //return redirect()->back()->withErrors($validator)->withInput($controlls);
        //     return response(['errors'=>$validator->errors()->all()], 422);
        // }
        $user = User::where('id',$request->id)->first();
        $hashedPassword = $user->password;
 
        if(Hash::check($request->old_password , $hashedPassword )) {
 
            if (!Hash::check($request->new_password , $hashedPassword)) {
                $users =User::find($request->id);
                $users->password = bcrypt($request->new_password);
                $users->save();
                //User::where( 'id' , auth::guard('user')->user()->id)->update( array( 'password' =>  $users->password));
                //$request->session()->put('alert', 'success');
                //$request->session()->put('change_passo', 'success');
                $response = ['status'=>true,"message" => "Password Changed Successfully"];
                return response($response, 200);
            }else{
                $response = ['status'=>true,"message" => "new password can not be the old password!"];
                return response($response, 422);
            }
 
        }else{
            $response = ['status'=>false,"message" => "old password does not matched"];
            return response($response, 422);
        }

    }

    public function verifyToken(Request $request)
    {
         $request->validate([
             'token' => 'required'
         ]);
         $query = User::where('remember_token',$request->token)->where('is_active',0)->first();
         if($query == null)
         {
             return response(['status' => false, 'errors' => ['Token not match']],422);
         }
         else{
            $query->is_active=1;
            $query->remember_token=null;
            $query->save();
             return response(['status' => true, 'message' => 'Email verify Succesfully','user'=>$query],200);
         }
 
    }
}
