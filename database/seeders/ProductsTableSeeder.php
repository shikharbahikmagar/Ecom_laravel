<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsRecords = [
            ['id'=>1, 'category_id'=>3, 'section_id'=>3, 'product_name'=>'Blue casual T-shirt', 'product_code'=>'BlT01',
            'product_color'=> 'blue','product_price'=>400, 'product_discount'=>20, 'product_weight'=>50.0, 'product_video' =>'',
            'main_image'=> '' , 'description'=>'Test product table', 'wash_care'=>'', 'fabric'=> '', 'pattern'=> '', 'sleeve'=> '',
            'fit'=> '', 'occasion'=> '', 'meta_title'=> '', 'meta_description'=> '', 'meta_keywords'=>'', 'is_featured'=>'No', 
            'status'=>1
            ],
    
            ['id'=>2, 'category_id'=>3, 'section_id'=>3, 'product_name'=>'Red casual T-shirt', 'product_code'=>'RdT02',
            'product_color'=> 'red','product_price'=>450, 'product_discount'=>15, 'product_weight'=>50.0, 'product_video' =>'',
            'main_image'=> '' , 'description'=>'Test product table', 'wash_care'=>'', 'fabric'=> '', 'pattern'=> '', 'sleeve'=> '',
            'fit'=> '', 'occasion'=> '', 'meta_title'=> '', 'meta_description'=> '', 'meta_keywords'=>'', 'is_featured'=>'Yes', 
            'status'=>1
            ],
            ];
    
            Product::insert($productsRecords);
    }
}
