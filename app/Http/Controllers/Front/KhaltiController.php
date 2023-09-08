<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Cart;
use Session;
use Auth;

class KhaltiController extends Controller
{
    public function khalti()
    {
        if(Session::has('order_id'))
        {
            Cart::where('user_id', Auth::user()->id)->delete();
            $orderDetails = Order::with('orders_products')->where('id', Session::get('order_id'))->first()->toArray();
            // echo "<pre>"; print_r($orderDetails); die;
            $nameArr = explode(' ', $orderDetails['name']);
            // echo "<pre>"; print_r($nameArr); die;
            return view('front.khalti.khalti')->with(compact('orderDetails', 'nameArr'));

        }else
        {
            return redirect('/cart');
        }
    }
}
