<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductsAttribute;

class Product extends Model
{
    public function section()
    {
        return $this->belongsTo('App\Section', 'section_id');
    }

    public function category()
    {
        return $this->belongsTO('App\Category', 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\brand', 'brand_id');
    }

    public function attributes()
    {
        return $this->hasMany('App\ProductsAttribute');
    }

    public function images()
    {
        return $this->hasMany('App\ProductsImage', 'product_id');
    }
    public static function productFilters()
    {
        $productFilters['fabricArray'] = array('Cotton', 'Polyester', 'Wool'); 
        $productFilters['patternArray'] =  array('Checked', 'Plain','Printed', 'Self', 'Solid');
        $productFilters['sleeveArray'] =  array('Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'Sleeveless');
        $productFilters['fitArray'] =  array('Regular', 'Slim');
        $productFilters['occasionArray'] =  array('Casual', 'Formal');
        return $productFilters;
    }

    public static function getDiscountedPrice($product_id)
    {
        $product_details = Product::select('product_price', 'product_discount', 'category_id')->where('id', $product_id)->first()->toArray();
        $category_details = Category::select('category_discount')->where(['id'=>$product_details['category_id']])->first()->toArray();
        if($product_details['product_discount']>0 )
        {
            $discounted_price = $product_details['product_price'] - ($product_details['product_price']*$product_details['product_discount']/100);
        }
        elseif($category_details['category_discount']>0)
        {
            $discounted_price = $product_details['product_price'] - ($product_details['product_price'] * $category_details['category_discount']/100);
        }else{
            $discounted_price = 0;
        }
        return $discounted_price;
    }

    public static function getAttrDiscountedPrice($product_id, $size)
    {
        $getAttrPrice = ProductsAttribute::where(['product_id'=>$product_id, 'size'=>$size])->first()->toArray();
        $product_details = Product::select('product_price', 'product_discount', 'category_id')->where('id', $product_id)->first()->toArray();
        $category_details = Category::select('category_discount')->where(['id'=>$product_details['category_id']])->first()->toArray();
        if($product_details['product_discount']>0 )
        {
            $final_price = $getAttrPrice['price'] - ($getAttrPrice['price']*$product_details['product_discount']/100);
            $discount = $getAttrPrice['price'] - $final_price;
        }
        elseif($category_details['category_discount']>0)
        {
            $final_price = $getAttrPrice['price'] - ($getAttrPrice['price'] * $category_details['category_discount']/100);
            $discount = ($getAttrPrice['price']*$category_details['category_discount']/100);
        }else{
            $final_price = 0;
        }
        return array('product_price'=>$getAttrPrice['price'], 'final_price'=>$final_price, 'discount'=>$discount);
    }

    //return image for order details page
    public static function getProductImage($product_id)
    {
        $getProductImage = Product::select('main_image')->where('id', $product_id)->first()->toArray();
        
        return $getProductImage['main_image']; 
    }
}
