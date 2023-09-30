<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Rating;

class RatingsController extends Controller
{
    public function ratings()
    {
        Session::put('page', 'ratings');
        $ratings = Rating::with(['user', 'products'])->get()->toArray();
        //echo "<pre>"; print_r($ratings); die;
        return view('admin.ratings.ratings')->with(compact('ratings'));
    }

     public function updateRatingStatus(Request $request)
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
        Rating::Where('id', $data['rating_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status, 'rating_id'=>$data['rating_id']]);
    }

    
}
