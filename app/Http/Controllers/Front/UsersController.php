<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;
use App\Cart;
use App\Sms;
use App\Country;


class UsersController extends Controller
{
    public function loginRegister()
    {
        return view('front.users.login_register');
    }

    public function userRegister(Request $request)
    {
        if($request->isMethod('post'))
        {
            Session::forget('error_message');
            Session::forget('success_message');
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $userCount = User::where('email',$data['email'])->count();
            // echo "<pre>"; print_r($userCount); die;
            if($userCount>0)
            {
                $message = "Email is already exists!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
            else
            {
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 1; 
                $user->save();

                // //send confirmation email
                // $email = $data['email'];
                // $messageData = [
                //     'name' => $data['name'],
                //     'email'=>$data['email'],
                //     'code'=>base64_encode($data['email'])
                // ];
                // Mail::send('emails.confirmation', $messageData, function($message) use($email){
                //     $message->to($email)->subject('Confirm your E-commerce Account');
                // });

                //return redirect back
                $message = "Successfully created account";
                Session::put('success_message', $message);
                return redirect()->back();

                if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']]))
                {
                    // echo "<pre>"; print_r(Auth::user()); die;
                    if(!empty(Session::get('session_id')))
                    {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                    }
                    //send Register sms
                    // $message = "Dear Customer, you have successfully registered with E-com website. Login
                    //             to your account to access orders and available offers.";
                    // $mobile = $data['mobile'];
                    // Sms::sendSms($message, $mobile);
                    //send email 
                    $email = $data['email'];
                    $messageData = ['name'=>$data['name'], 'mobile'=>$data['mobile'], 'email'=>$data['email']];
                    Mail::send('emails.register', $messageData, function($message) use($email){
                        $message->to($email)->subject('Welcome to E-commerce Website');
                    });
                    return redirect('/printed_hoodie');
                }
            }

        }

    }
    //confirm email
    public function confirmAccount($email)
    {
        Session::forget('error_message');
        Session::forget('success_message');
        $email = base64_decode($email); 
        //check user activation
        $userCount = User::where('email', $email)->count();
        if($userCount>0)
        {
            $userDetails = User::where('email', $email)->first();
            if($userDetails->status==1)
            {
                $message = "Your Email account is already activated. Please Login.";
                Session::put('error_message', $message);
                return redirect('login-register');
            }
            else
            {
                //update users status 1 to activate
                User::where('email', $email)->update(['status'=>1]);
                    // send Register sms
                    // $message = "Dear Customer, you have successfully registered with E-com website. Login
                    //             to your account to access orders and available offers.";
                    // $mobile = $data['mobile'];
                    // Sms::sendSms($message, $mobile);
                    // send email 
                    $messageData = ['name'=>$userDetails['name'], 'mobile'=>$userDetails['mobile'], 'email'=>$userDetails['email']];
                    Mail::send('emails.register', $messageData, function($message) use($email){
                        $message->to($email)->subject('Welcome to E-commerce Website');
                    });
                    //redirect to login-register with success message
                    $message = "Your Email is activated. You can login now.";
                    Session::put('success_message', $message);
                    return redirect('login-register');
            }
        }   
    }
    //check if email is already exist or not
    public function checkEmail(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            $emailCount = User::where('email', $data['email'])->count();
            // echo "<pre>"; print_r($emailCount); die;
            if($emailCount>0)
            {
                return "false";
            }
            else
            {
                return "true";
            }

        }
    }
    //user login
    public function userLogin(Request $request)
    {
        if($request->isMethod('post'))
        {
            Session::forget('error_message');
            Session::forget('success_message');
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']]))
            {
                // check account is activated or not
                $userStatus = user::where('email', $data['email'])->first();
                if($userStatus->status==0)
                {
                    Auth::logout();
                    $message = "Your account is not activated yet! please confirm your email to activate!";
                    Session::put('error_message', $message);
                    return redirect()->back();
                }
                //update user cart with user_id
                if(!empty(Session::get('session_id')))
                {
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                }
                return redirect('/cart');
            }
            else
            {
                $message="Invalid username and password";
                Session::flash('error_message', $message);
                return redirect()->back();

            }
        }
    }
    //user logout
    public function logoutUser()
    {
        Auth::logout();
        return redirect('/');
    }
    //user forgot password
    public function forgotPassword(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $emailCount = User::where('email',  $data['email'])->count();
            if($emailCount == 0)
            {
                $message = "Email does not exists!";
                Session::put('error_message', $message);
                Session::forget('success_message');
                return redirect()->back();
            }
            // echo "email exists"; die;
            //generate random password
            $random_pasword = str_random(8);
            //encode secore password
            $new_password = bcrypt($random_pasword);
            //update new password
            User::where('email', $data['email'])->update(['password'=>$new_password]);
            //get username
            $userName = User::select('name')->where('email', $data['email'])->first();
            $name = $userName->name;
            $email = $data['email'];
            $messageData = [
                'email' => $data['email'],
                'name' => $name,
                'password' => $random_pasword
            ];
            Mail::send('emails.forgot_password', $messageData, function($message) use($email){
                $message->to($email)->subject('New Password - E-commerce Website');
            });
            //return login-register page with success message
            $message = "Please check your email for new Password!";
            Session::put('success_message', $message);
            Session::forget('error_message');
            return redirect('login-register');

        }   
        return view('front.users.forgot_password');
    }
    //my account
    public function account(Request $request)
    {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id)->toArray();
        $countries = Country::where('status', 1)->get()->toArray();
        // dd($countries);
        // $userDetails = json_decode(json_encode($userDetails));
        // dd($userDetails);
        if($request->isMethod('post'))
        {
            $data = $request->all();
            Session::forget('error_message');
            Session::forget('success_message');
            //   echo "<pre>"; print_r($data); die;

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|numeric', 
            ];
            $customMessages = [
                'name.required' => 'Name is required',
                'name.alpha' => 'Valid name is required',
                'mobile.required' => 'Mobile number is required',
                'mobile.numeric' => 'Valid number is required',
            ];
            $this->validate($request, $rules, $customMessages);

            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();
            $message = "Your account has been updated successfully!";
            Session::put('success_message', $message);
            Session::forget('error_message');
            return redirect()->back();
        }
        return view('front.users.account')->with(compact('userDetails', 'countries'));
    }
    //check user password
    public function checkeUserPwd(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            // $current_pwd = bcrypt($data['current_pwd']);
            // echo "<pre>"; print_r($current_pwd); die;
            $user_id = Auth::User()->id;
            $old_pwd = User::select('password')->where('id', $user_id)->first();

            // echo "<pre>"; print_r($old_pwd); die;
            if(Hash::check($data['current_pwd'], $old_pwd->password))
            {
               return "true";
            }else
            {
                return "false";
            }
        }
    }
    //update user password
    public function updateUserPwd(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            //  echo "<pre>"; print_r($data); die;
            $new_password = bcrypt($data['new_password']);
            $user_id = Auth::User()->id;
            $old_pwd = User::select('password')->where('id', $user_id)->first();
            if(Hash::check($data['current_password'], $old_pwd->password))
            {
                User::where('id', $user_id)->update(['password'=>$new_password]);
                $message = "Password updated successfully";
                Session::put('success_message', $message);
                Session::forget('error_message');
                return redirect()->back();
            }else
            {
                $message = "Current Password is Incorrect!";
                Session::put('error_message', $message);
                Session::forget('success_message');
                return redirect()->back();
            }
           
        }
    }
}
