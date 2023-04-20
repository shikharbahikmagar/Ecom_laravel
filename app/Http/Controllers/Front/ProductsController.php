<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;

class ProductsController extends Controller
{
    public function listing($url)
    {
        $categoriesCount = Category::where(['url'=>$url, 'status'=>1])->count();
         
        if($categoriesCount>0)
        {
            
            $categoryDetails = Category::categoryDetails($url);
            $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])
            ->where('status', 1);
            //check if sort is selected by user or not
            if(isset($_GET['sort']) && !empty($_GET['sort']))
            {
                if($_GET['sort']=="latest_product")
                {
                    $categoryProducts->orderBy('id', 'Desc');
                }
                elseif($_GET['sort']=="price_low_to_high")
                {
                        $categoryProducts->orderBy('product_price', 'Asc');
                }
                elseif($_GET['sort']=="price_high_to_low")
                {
                    $categoryProducts->orderBy('product_price', 'Desc');
                }
                elseif($_GET['sort']=="product_name_a_to_z")
                {
                    $categoryProducts->orderBy('product_name', 'Asc');
                }
                elseif($_GET['sort']=="product_name_z_to_a")
                {
                    $categoryProducts->orderBy('product_name', 'Desc');
                }
                
            }else{
                $categoryProducts->orderBy('id', 'Desc');
            }

            $categoryProducts = $categoryProducts->paginate(3);

            // echo "<pre>"; print_r($categoryDetails); die;
            // echo "<pre>"; print_r($categoryProducts); die;
            return view ('front.products.listings')->with(compact('categoryDetails', 'categoryProducts'));
        }
        else
        {
            abort(404);
        }

    }
}
