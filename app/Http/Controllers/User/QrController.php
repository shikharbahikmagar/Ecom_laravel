<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Admin;
class QrController extends Controller
{
        public function index(Request $request) {
    
		return view('front.users.QrLogin');
	}
	
	// this Function Allow to User log or no log that do by Scanner of QrCode
	// public function checkUser(Request $request) {
	// 	 $result =0;
	// 		if ($request->data) {
	// 			$user = User::where('name',$request->data)->first();
	// 			if ($user) {
	// 				Auth::login($user);
	// 			    $result =1;
	// 			 }else{
	// 			 	$result =0;
	// 			 }
    //         }
	// 		return $result;
	// }
    public function checkUser(Request $request) {
        if($request->ajax())
        {
			$check =0;
            $data = $request->all();
            // $data = json_decode(json_encode($data), true);
            //$data1 = Hash::check($data, Auth::guard('admin')->user()->pincode);
			// echo "<pre>"; print_r($data['arrayInfo']['0']); die;
			
			//  $admins = json_decode(json_encode($admins), true);
			//  $adminCount = $admins['email'];
			//echo "<pre>"; print_r($admins); die;
				if(!empty($data['arrayInfo']['0']) && !empty($data['arrayInfo']['1']))
				{
					$email = $data['arrayInfo']['0'];
			
					$pass = $data['arrayInfo']['1'];
			
					if (Auth::guard('admin')->attempt(['email'=>$email, 'password'=>$pass])) 
					{
						$check =1;
						return $check;
					}else{
						$check =0;
						return $check;
					}
				}else
				{
					$check = 0;
					return $check;
				}

				
			
		}
    }
}
