<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public static function banners()
    {        
        $bannerData = Banner::where('status', 1)->get();
        $bannerData = json_decode(json_encode($bannerData), true);
        // echo "<pre>"; print_r($bannerData); die;
        return $bannerData;
    }
}
