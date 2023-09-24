<?php

use Illuminate\Database\Seeder;
use App\ProductsAttribute;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsAttributesRecords = [
            ['id'=>1, 'product_id'=>1, 'size'=>'small', 'price'=>1000, 'stock'=>10, 'sku'=>'BLUE101-S', 'status'=>1],
            ['id'=>2, 'product_id'=>1, 'size'=>'medium', 'price'=>1100, 'stock'=>15, 'sku'=>'BLUE101-M', 'status'=>1],
            ['id'=>3, 'product_id'=>1, 'size'=>'large', 'price'=>1200, 'stock'=>5, 'sku'=>'BLUE101-L', 'status'=>1],
        ];

        
    ProductsAttribute::insert($productsAttributesRecords);
    }

}
