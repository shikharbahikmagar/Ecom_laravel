<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use App\Section;
use App\User;
use Session;

class CouponsController extends Controller
{
    public function coupons()
    {
        Session::put('page', 'coupons');
        $coupons = Coupon::get()->toArray();
        // dd($coupons);
        return view('admin.coupons.coupons')->with(compact('coupons'));

    }
    //update coupon status
    public function updateCouponStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            
            if($data['status']=="Active")
            {
                $status = 0;
            }else
            {
                $status = 1;
            }
        }
        Coupon::Where('id', $data['coupon_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status, 'coupon_id'=>$data['coupon_id']]);
    }
    //delete coupon id
    public function deleteCoupon($id)
    {
        Coupon::where('id', $id)->delete();
        Session::flash('success_message', 'Coupon Deleted Successfully');
        return redirect()->back();
    }

    //add edit coupons
    public function addEditCoupon(Request $request, $id=null)
    {
        if($id == "") 
        {
            $title = "Add Coupon";
            $coupon = new Coupon;
            $selCats = array();
            $selUsers = array();
            $message = "Coupon Added Successfully";
            $sub_btn_name = "Submit";

        }else
        {
            $title = "Edit Coupon";
            $coupon = Coupon::find($id);
            $selCats = explode(',', $coupon['categories']);
            $selUsers = explode(',', $coupon['users']);
            $message = "Coupon updated Successfully";
            $sub_btn_name = "Update";
        }
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            //product validations
            $rules = [
                'categories' => 'required',
                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required|numeric',
                'expiry_date' => 'required',
            ];
            $customMessages = [
                'categories.required' => 'Select Categories',
                'coupon_option.required' => 'Select Coupon Option',
                'coupon_type.required' => 'Select Coupon Type',
                'amount_type.required' => 'Select Amount Type',
                'amount.required' => 'Amount is Required',
                'amount.numeric' => 'Valid Amount is Required',
                'expiry_date.required' => 'Expiry Date is Required',
            ];
            $this->validate($request, $rules, $customMessages);
            //check for users
            if(isset($data['users']))
            {
                $users = implode(',', $data['users']);
            }
            else
            {
                $users = "";
            }
            //check for categories
            if(isset($data['categories']))
            {
                $categories = implode(',', $data['categories']);
            }
            //check coupon type
            if($data['coupon_option']=="automatic")
            {
                $coupon_code = str_random(8);
            }
            else
            {
                $coupon_code = $data['coupon_code'];
            }
            

            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->users = $users;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = 1; 
            $coupon->save();

            
            Session::flash('success_message', $message);
            return redirect('/admin/coupons');
            
        }

        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);
        $users = User::select('email')->where('status', 1)->get()->toArray();
        // dd($categories);

        return view('admin.coupons.add_edit_coupons')->with(compact('title', 'sub_btn_name', 'coupon', 'categories', 'users','selCats', 'selUsers'));
        // 

    }

}
