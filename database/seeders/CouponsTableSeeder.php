<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Coupon;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $couponRecords = 
        [
            [
                'id'=>1, 'coupon_option'=>'Manual', 'coupon_code'=>'test10', 'categories'=>'1,2',
                'users'=>'bk@yopmail.com, bbb@yopmail.com', 'coupon_type'=>'single', 'amount_type'=>'percentage',
                'amount'=>10, 'expiry_date'=>'2023-3-3', 'status'=>1
            ]
        ];
        Coupon::insert($couponRecords);
    }

}
