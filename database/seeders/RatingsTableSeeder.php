<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Rating;
use DB;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratingRecords = [
            ['id'=>1, 'user_id'=>10, 'product_id'=>1, 'review'=>'ramro xa', 'rating'=>5, 'status'=>1],
            ['id'=>2, 'user_id'=>1, 'product_id'=>5, 'review'=>'ramro xa', 'rating'=>3, 'status'=>1],
            ['id'=>3, 'user_id'=>5, 'product_id'=>6, 'review'=>'ramro xa', 'rating'=>4, 'status'=>1]
        ];

        Rating::insert($ratingRecords);
    }
}
