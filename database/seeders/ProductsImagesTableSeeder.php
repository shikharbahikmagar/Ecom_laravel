<?php

use Illuminate\Database\Seeder;
use App\ProductsImage;

class ProductsImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsImagesRecords = [
            ['id'=>1, 'product_id'=>1, 'image'=>'mens-tshirt-8701.jpg', 'status'=>1],
        ];

        ProductsImage::insert($productsImagesRecords);
    }
}
