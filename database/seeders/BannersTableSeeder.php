<?php

use Illuminate\Database\Seeder;
use App\Banner;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannersRecords = [
            ['id'=>1, 'image'=>'banner1.png', 'link'=> 'black-jacket', 'title'=> 'Black Jacket', 'alt'=>'Black Jacket', 'status'=>1],
            ['id'=>2, 'image'=>'banner2.png', 'link'=> 'blue-half-sleeves-tshirt', 'title'=> 'Blue T-Shirt', 'alt'=>'Blue T-Shirt', 'status'=>1],
            ['id'=>3, 'image'=>'banner3.png', 'link'=> 'blue-long-sleeves-tshirt', 'title'=> 'Blue Long Sleeves', 'alt'=>'Blue Long SLeeves', 'status'=>1],
        ];
        Banner::insert($bannersRecords);
    }
}
