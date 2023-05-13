<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Section;
use App\Category;
use App\ProductsAttribute;
use Session;
use Image;
use App\Brand;
use App\ProductsImage;

class ProductsController extends Controller
{
    public function product()
    {
        Session::put('page', 'products');
        $products = Product::with(['category'=>function($query){
            $query->select('id', 'category_name');
        }, 'section'=>function($query){
            $query->select('id', 'name');
        }])->get();

        // $products = json_decode(json_encode($products));
        // echo "<pre>"; print_r($products); die;
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            if($data['status'] == "Active")
            {
                $status = 0;
            }else
            {
                $status = 1;
            }

        }
        Product::where('id', $data['product_id'])->update(['status'=> $status]);
        return response()->json(['status'=>$status, 'product_id'=>$data['product_id']]);
    }

    //delete product
    public function deleteProduct($id)
    {
        Product::where('id', $id)->delete();
        Session::flash('success_message', 'Product deleted successfully');
        return redirect()->back();
    }

    //add edit product
    public function addEditProduct(Request $request, $id=null)
    {
        if($id==null)
        {
            $title = "Add Product";
            $productdata = array(); 
            $submit = "Submit";
            $product = new Product;
            $message = "Product added successfully";
        }
        else{
            $title = "Edit Product";
            $productdata = Product::find($id);
            // $productdata = json_decode(json_encode($productdata), true);
            // echo "<pre>"; print_r($productdata); die;
            $submit = "Update";
            $product = Product::find($id);
            $message = "Product Updated successfully";
          
        }
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // dd($data);

            //product validations
            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages = [
                'category_id.required' => 'category is required',
                'product_name.required' => 'Name is required',
                'product_name.regex' => 'Valid name is required',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'valid product code is required',
                'product_price.required' => 'Product price is required',
                'product_price.numeric' => 'valid product price is required',
                'product_color.required' => 'Product color is required',
                'product_color.regex' => 'Valid product color is required',
            ];

            $this->validate($request, $rules, $customMessages);

            if(empty($data['is_featured']))
            {
                $is_featured = "No";
            }else
            {
                $is_featured = "Yes";
            }
            
            //upload image
            if($request->hasFile('main_image'))
            {
                $image_tmp = $request->file('main_image');
                if($image_tmp->isValid())
                {
                    $image_name = $image_tmp->getClientOriginalName();
                    $ImageFileName = pathinfo($image_name,PATHINFO_FILENAME);
                    $image_extension = $image_tmp->getClientOriginalExtension();
                    $imageName = $ImageFileName.'-'.rand(111,9999).'.'.$image_extension;
                    $large_image_path = 'images/product_images/large/'.$imageName;
                    $medium_image_path = 'images/product_images/medium/'.$imageName;
                    $small_image_path = 'images/product_images/small/'.$imageName;
                    //save image to product_images folder
                    Image::make($image_tmp)->save($large_image_path); //original size will be  1040*1200 
                    Image::make($image_tmp)->resize(520, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260, 300)->save($small_image_path);
                    //save image name to database
                    $product->main_image = $imageName;
                }
            }

            //upload video of product
            if($request->hasFile('product_video'))
            {
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid())
                {
                    $video_name = $video_tmp->getClientOriginalName();
                    
                    $videoFileName = pathinfo($video_name,PATHINFO_FILENAME);
                    $video_extension = $video_tmp->getClientOriginalExtension();
                    
                    $videoName = $videoFileName.'-'.rand(111, 9999).'.'.$video_extension;
                    // dd($videoName);
                    $video_path = 'videos/product_videos/';
                    //move video to videos/product_videos
                    $video_tmp->move($video_path, $videoName);
                    //save to table
                    $product->product_video = $videoName;

                }
            }


            //save product details into table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->is_featured = $is_featured;
            $product->brand_id = $data['brand_id'];
            $product->status = 1;

            $product->save();

            Session::flash('success_message', $message);
            return redirect('admin/products');
        }
        //product filter
        $productFilters = Product::productFilters();
        //  echo "<pre>"; print_r($productFilters); die;
        $fabricArray = $productFilters['fabricArray'];
        $patternArray = $productFilters['patternArray'];
        $sleeveArray = $productFilters['sleeveArray'];
        $fitArray = $productFilters['fitArray'];
        $occasionArray = $productFilters['occasionArray'];

        //sections with categories and sub categories
        $categories = Section::with('categories')->get();
        // $categories = json_decode(json_encode($categories));
        // echo "<pre>"; print_r($categories); die;
        $brands = Brand::where('status', 1)->get();
        // dd($brands);


        return view('admin.products.add_edit_product')->with(compact('title', 'productdata', 'submit',
    'fabricArray', 'patternArray', 'sleeveArray', 'fitArray', 'occasionArray', 'categories','brands'));
    }

    //delete product image
    
    public function deleteProductImage($id)
    {
        $productImage = Product::select('main_image')->where('id', $id)->first();
        $product_image_large_path = 'images/product_images/large/';
        $product_image_medium_path = 'images/product_images/medium/';
        $product_image_small_path = 'images/product_images/small/';

        //delete image from product image folder
        if(file_exists($product_image_large_path.$productImage->main_image) && file_exists($product_image_medium_path.$productImage->main_image)
        && file_exists($product_image_small_path.$productImage->main_image))
        {
            unlink($product_image_large_path.$productImage->main_image);
            unlink($product_image_medium_path.$productImage->main_image);
            unlink($product_image_small_path.$productImage->main_image);
        }

        //delete image from database
        Product::where('id', $id)->update(['main_image'=>'']);

        Session::flash('success_message', 'Image deleted');
        return redirect()->back();

    }

    public function deleteProductVideo($id)
    {
        $productVideo = Product::select('product_video')->where('id', $id)->first();
        $product_video_path = 'videos/product_videos/';

        //delete video from product video folder
        if(file_exists($product_video_path.$productVideo->product_video))
        {
            unlink($product_video_path.$productVideo->product_video);
        }

        //delete video from database
        Product::where('id', $id)->update(['product_video'=>'']);

        Session::flash('success_message', 'video deleted successfully');
        return redirect()->back();

    }

    //add attributes
    public function AddAttributes(Request $request, $id)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach($data['sku'] as $key=>$value)
            {
                if(!empty($value))
                {
                //check if size already exist
                $attrSizeCount = ProductsAttribute::where(['product_id' => $id, 'size'=>$data['size'][$key]])->count();
                if($attrSizeCount>0)
                {
                    $message = "Size alreday exist, please add another size!";
                    Session::flash('error_message', $message);
                    return redirect()->back();
                }
                //check if sku already exist
                $attrSkuCount = ProductsAttribute::where('sku', $value)->count(); 
                if($attrSkuCount>0)
                {
                    $message = "SKU already exist, please add another sku!";
                    Session::flash('error_message', $message);
                    return redirect()->back();
                }

                $attribute = new ProductsAttribute;
                $attribute->product_id = $id; 
                $attribute->sku = $value;
                $attribute->size = $data['size'][$key];
                $attribute->price = $data['price'][$key];
                $attribute->stock = $data['stock'][$key];
                $attribute->status = 1;
                $attribute->save();

                }
            }
            Session::flash('success_message', 'Products Attributes added successfully');
            return redirect()->back();
        }


        $productdata = Product::select('id', 'product_name', 'product_code', 'product_color', 'main_image')->with('attributes')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        $title = "Products Attribute";
        $submit = "Submit";
        // echo "<pre>"; print_r($productdata); die;

        return view('admin.products.add_attributes')->with(compact('productdata', 'title', 'submit'));
    }

    //edit attribute
    public function editAttribute(Request $request, $id)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // dd($data);

            foreach($data['attrId'] as $key => $attr)
            {
                if(!empty($attr))
                {
                ProductsAttribute::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'] [$key], 'stock'=>$data['stock'][$key]]);
                }
            }
            $message = "successfully updated products attributes";
            Session::flash('success_message', $message);
            return redirect()->back();
        }

    }

    public function updateProductAttributeStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            if($data['status'] == "Active")
            {
                $status = 0;
            }else
            {
                $status = 1;
            }

        }
        ProductsAttribute::where('id', $data['attribute_id'])->update(['status'=> $status]);
        return response()->json(['status'=>$status, 'attribute_id'=>$data['attribute_id']]);
    }

    public function deleteAttribute($id)
    {
        ProductsAttribute::where('id', $id)->delete();
        Session::flash('success_message', 'attribute has been deleted successfully');
        return redirect()->back();
    }

    //add images
    public function addImages(Request $request, $id)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            if($request->hasFile('images'))
            {
                $images = $request->file('images');

                foreach($images as $key=>$image)
                {
                    $productImage = new ProductsImage;
                    $image_tmp = Image::make($image);
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111, 999999).time().".".$extension;
                    //setting paths
                    $image_large_path = 'images/product_images/large/'.$imageName;
                    $image_medium_path = 'images/product_images/medium/'.$imageName;
                    $image_small_path = 'images/product_images/small/'.$imageName;

                    //upload image
                    Image::make($image_tmp)->save($image_large_path);
                    Image::make($image_tmp)->resize(520, 600)->save($image_medium_path);
                    Image::make($image_tmp)->resize(260, 300)->save($image_small_path);

                    $productImage->image = $imageName;
                    $productImage->product_id = $id;
                    $productImage->status = 1;
                    $productImage->save();                   

                }
                Session::flash('success_message', 'images added successfully');
                return redirect()->back();

            }
        }
        $productdata = Product::with('images')->select('id', 'product_name', 'product_code', 'product_color', 'main_image')->find($id);
        // $productdata = json_decode(json_encode($productdata), true);
        // echo "<pre>"; print_r($productdata); die;
        return view('admin.products.add_images')->with(compact('productdata'));
     
    }

    public function updateImageStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            if($data['status'] == "Active")
            {
                $status = 0;
            }else
            {
                $status = 1;
            }

        }
        ProductsImage::where('id', $data['image_id'])->update(['status'=> $status]);
        return response()->json(['status'=>$status, 'image_id'=>$data['image_id']]);
    }

    public function deleteAltImage($id)
    {
        $productImage = ProductsImage::select('image')->where('id', $id)->first();
        // dd($productImage);
        $product_image_large_path = 'images/product_images/large/';
        $product_image_medium_path = 'images/product_images/medium/';
        $product_image_small_path = 'images/product_images/small/';

        //delete image from product image folder
        if(file_exists($product_image_large_path.$productImage->main_image) && file_exists($product_image_medium_path.$productImage->main_image)
        && file_exists($product_image_small_path.$productImage->main_image))
        {
            unlink($product_image_large_path.$productImage->image);
            unlink($product_image_medium_path.$productImage->image);
            unlink($product_image_small_path.$productImage->image);
        }

        //delete image from database
        ProductsImage::where('id', $id)->delete();

        Session::flash('success_message', 'Image deleted');
        return redirect()->back();
    }

}
