<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Session;
use App\Admin;
use Image;


class AdminController extends Controller
{
    //settings
    public function setting(Request $request)
    {
        Session::put('page', 'settings');
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first(); 

        return view('admin.admin_setting')->with(compact('adminDetails'));
    }
    //login
    public function login(Request $request)
    {
        if($request->isMethod('POST'))
        {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die; 
        // dd($data);
        $rules = [
            'email' => 'email|required|max:250',
            'password' => 'required',
    
           ];
           $customMessages = [
            'email.required' => 'Email is required',
            'email.email' => 'Enter valid email',
            'password.required' => 'Password is required', 
           ];
    
           $this->validate($request, $rules, $customMessages );


        if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
            return redirect('admin/dashboard');
       }else{
            Session::flash('error_message','Invalid Email or Password');

            return redirect()->back();
       }


    }
        // dd (Hash::make('123456'));
        return view('admin.admin_login');
    }

    //logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    //dashboard
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        return view('admin.admin_dashboard');
    }

    //check current password
    public function chkCurrentPassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password))
        {
            echo "true";
        }
        else
        {
            echo "false";
        }
    }

    //update current password
    public function updateCurrentPassword(Request $request)
    {
      
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password))
            {
                if($data['new_pwd']==$data['confirm_pwd'])
                {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt( $data['new_pwd'])]);
                    Session::flash('success_message', 'Successfully updated password');
                    return redirect()->back();
                }
                else
                {
                    Session::flash('error_message', 'new password and confirm password did not matched!');
                    return redirect()->back();
                }
            }
            else
            {
                Session::flash('error_message', 'your current password is incorrect');
                return redirect()->back();
            }
        }
    }

    //update admin details
    public function updateAdminDetails(Request $request)
    {
        Session::put('page', 'update_admin_details');
           if($request->isMethod('post'))
        {
            $data = $request->all();
            // dd($data);
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric', 
                'admin_image' => 'image', 
            ];
            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.alpha' => 'Valid name is required',
                'admin_mobile.required' => 'Mobile number is required',
                'admin_mobile.numeric' => 'Valid number is required',
                'admin_image.image' => 'valid image is required',
            ];

            $this->validate($request, $rules, $customMessages);

            if(empty($data['admin_image']))
            {
                $imageName= "";
            }

            //upload image
            if($request->hasFile('admin_image'))
            {
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid())
                {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    
                    //upload the image

                    Image::make($image_tmp)->save($imagePath);
                }else if(!empty($data['current_admin_image']))
                {
                    $imageName = $data['current_admin_image'];
                }else
                {
                    $imageName = "";
                }
            }

            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name' => $data['admin_name'], 'mobile'
            => $data['admin_mobile'], 'image'=> $imageName]);
            Session::flash('success_message', 'successfully updated ');
            return redirect()->back();

        }
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.update_admin_details')->with(compact('adminDetails'));
    }
}
