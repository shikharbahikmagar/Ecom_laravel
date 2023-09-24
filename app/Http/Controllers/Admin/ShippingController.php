<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ShippingCharge;
use Session;

class ShippingController extends Controller
{
    public function shippingCharge()
    {
        Session::put('page', 'shipping_charges');
        $shipping_charges_details = ShippingCharge::where('status', 1)->get()->toArray();
        // echo "<pre>"; print_r($shipping_charges_details); die;
        return view('admin.shipping.view_shipping_charges')->with(compact('shipping_charges_details'));
    }

    public function editShippingCharge($id, Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            ShippingCharge::where('id', $id)->update(['shipping_charges' => $data['shipping_charge']]);
            $message = "Shipping Charges updated successfully";
            Session::put('success_message', $message);
            return redirect('/admin/shipping-charges');
        }
        $shippingDetails = ShippingCharge::where('id', $id)->first()->toArray();
        // echo "<pre>"; print_r($shippingDetails); die;
        return view('admin.shipping.edit_shipping_charge')->with(compact('shippingDetails'));
    }
    //update shipping status
    public function updateShippingStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            // echo "<pre>"; print_r($shippingDetails); die;
            if($data['status']=="Active")
            {
                $status = 0;
            }else
            {
                $status = 1;
            }
        }
        ShippingCharge::Where('id', $data['shipping_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status, 'shipping_id'=>$data['shipping_id']]);
    }
}
