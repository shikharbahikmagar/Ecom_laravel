<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use Auth;

class OrdersController extends Controller
{
    public function orders()
    {
        $orders = Order::with('orders_products')->where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get()->toArray();
        return view('front.orders.orders')->with(compact('orders'));
    }
    //view order details
    public function orderDetails($id)
    {
        $orderDetails = Order::with('orders_products')->where('id', $id)->first()->toArray();
        // dd($orderDetails);
        return view('front.orders.order_details')->with(compact('orderDetails'));
    }
}
