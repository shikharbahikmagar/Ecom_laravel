<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Rating;

class RatingsController extends Controller
{
    public function addRating(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
             if(!Auth::check())
            {
                $message = "please login to review product";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
            if(empty($data['rating']))
            {
                $message = "Add atleast 1 star Rate";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
            $message = "You already review this product";
            $ratingCount = Rating::where(['user_id'=>Auth::user()->id, 'product_id'=>$data['product_id'] ])->count();
            if($ratingCount>0)
            {
                Session::flash('error_message', $message);
                return redirect()->back();
            }
            else
            {
                $rating = new Rating;
                $rating->product_id = $data['product_id'];
                $rating->user_id = Auth::user()->id;
                $rating->review = $data['review'];
                $rating->rating = $data['rating'];
                $rating->status = 0;
                $rating->save();
                $message = "Thanks for rating this product it will be shown once approved.";
                Session::flash('success_message', $message);
                return redirect()->back();
            }
        }

    
        }
}
