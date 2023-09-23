<?php

namespace App\Http\Controllers\Front;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use App\Cart;
use App\Coupon;
use App\User;
use Carbon\Carbon;
use App\DeliveryAddress;
use App\Country;
use App\Order;
use App\OrdersProduct;
use App\Sms;
use App\ShippingCharge;
use Session;
use Auth;
use DB;


class ProductsController extends Controller
{
    public function listing(Request $request)
    {
        Paginator::useBootstrap();
        if($request->ajax())
        {
            $data = $request->all();
            
            $url = $data['url'];
            // echo "<pre>"; print_r($url); die;  
            $categoriesCount = Category::where(['url'=>$url, 'status'=>1])->count();
         
            if($categoriesCount>0)
            {
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])
                ->where('status', 1);
               
                //check if fabric filter is slected
                if(isset($data['fabric']) && !empty($data['fabric']))
                {
                    $categoryProducts->whereIn('products.fabric', $data['fabric']);
                }
                //if pattern filter is selected
                if(isset($data['pattern']) && !empty($data['pattern']))
                {
                    $categoryProducts->whereIn('products.pattern', $data['pattern']);
                }
                //if sleeve filter is selcted
                if(isset($data['sleeve']) && !empty($data['sleeve']))
                {
                    $categoryProducts->whereIn('products.sleeve', $data['sleeve']);
                }
                //check if fit filter is selcted
                if(isset($data['fit']) && !empty($data['fit']))
                {
                    $categoryProducts->whereIn('products.fit', $data['fit']);
                }
                //check if occasion filter is selcted
                if(isset($data['occasion']) && !empty($data['occasion']))
                {
                    $categoryProducts->whereIn('products.occasion', $data['occasion']);
                }

                //check if sort is selected by user or not
                if(isset($data['sort']) && !empty($data['sort']))
                {
                    if($data['sort']=="latest_product")
                    {
                        $categoryProducts->orderBy('id', 'Desc');
                    }
                    elseif($data['sort']=="price_low_to_high")
                    {
                            $categoryProducts->orderBy('product_price', 'Asc');
                    }
                    elseif($data['sort']=="price_high_to_low")
                    {
                        $categoryProducts->orderBy('product_price', 'Desc');
                    }
                    elseif($data['sort']=="product_name_a_to_z")
                    {
                        $categoryProducts->orderBy('product_name', 'Asc');
                    }
                    elseif($data['sort']=="product_name_z_to_a")
                    {
                        $categoryProducts->orderBy('product_name', 'Desc');
                    }
                    
                }
                else
                {
                    $categoryProducts->orderBy('id', 'Asc');
                }
    
                $categoryProducts = $categoryProducts->paginate(6);
    
                // echo "<pre>"; print_r($categoryDetails); die;
                // echo "<pre>"; print_r($categoryProducts); die;
                return view ('front.products.ajax_products_listings')->with(compact('categoryDetails', 'categoryProducts',
                'url'));
            }
            else
            {
                abort(404);
            }   

        }
        else
        {
            $url = Route::getFacadeRoot()->current()->uri();
            $categoriesCount = Category::where(['url'=>$url, 'status'=>1])->count();
            //search produt
            if(isset($_REQUEST['search']) && !empty($_REQUEST['search']))
            {
                $search_product = $_REQUEST['search'];
                $categoryDetails['breadcrumbs'] = $search_product;
                $categoryDetails['categoryDetails']['category_name'] = $search_product;
                $categoryDetails['categoryDetails']['description'] = "Searching Results For".$search_product;
                $categoryProducts = Product::with('brand')->where(function($query)use($search_product){
                    $query->where('product_name', 'like', '%'.$search_product.'%')
                    ->orWhere('product_code', 'like', '%'.$search_product.'%')
                    ->orWhere('product_color', 'like', '%'.$search_product.'%');
                })->where('status', 1);
                $categoryProducts = $categoryProducts->get();
                $page_name = "Search Product";
                return view('front.products.listings')->with(compact('page_name', 'categoryDetails', 'categoryProducts'));

            }
            else if($categoriesCount>0)
            {
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])
                ->where('status', 1);
                $categoryProducts = $categoryProducts->paginate(6);
                // dd($categoryProducts->id);
                // echo "<pre>"; print_r($categoryProducts); die;  

                //product filter
                $productFilters = Product::productFilters();
                
                $fabricArray = $productFilters['fabricArray'];
                $patternArray = $productFilters['patternArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];

                $page_name = "listing";
                return view ('front.products.listings')->with(compact('categoryDetails', 'categoryProducts',
                'url', 'fabricArray', 'patternArray', 'sleeveArray', 'fitArray', 'occasionArray', 'page_name'));
            }
            else
            {
                abort(404);
            }   
        }
    }

    public function details($id)
    {
        $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');
        // dd($total_stock);
        $productDetails = Product::with(['category','brand','attributes'=>function($query)
        {
            $query->where('status', 1);
        },'images'])->find($id)->toArray();
        $relatedProducts = Product::where('category_id', $productDetails['category']['id'])->where('id', '!=', $id)->limit(3)->inRandomOrder()
        ->get()->toArray();
        // dd($relatedProducts);
        // dd($productDetails);
        return view('front.products.details')->with(compact('productDetails', 'total_stock', 'relatedProducts'));
    }

    //returning price
    public function getProductPrice(Request $request)
    {
        if($request->ajax()){
        
        $data = $request->all();
        // echo"<pre>"; print_r($data); die;
        $get_discounted_price = Product::getAttrDiscountedPrice($data['product_id'], $data['size']);
        return $get_discounted_price;
        }
    }

    //add to cart function
    public function addtoCart(Request $request)
    {
        if($request->isMethod("post"))
        {
            $data = $request->all();
            //check product stock is available or not
            $getProductStock = ProductsAttribute::where(['product_id'=>$data['product_id'], 'size'=>$data['size']])->first()->toArray();
            // dd($getProductStock['stock']);
            if($getProductStock['stock'] < $data['quantity'])
            {
                $message = "Required quantity is not available";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            //generate session id if not exists
            $session_id = Session::get('session_id');
            if(empty($session_id))
            {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            //check if product is already exists in user cart
            if(Auth::check())
            {
                //user logged in
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'user_id'=>
                Auth::user()->id])->count();
            }
            else
            {
                //user not logged in
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'session_id'=>
                Session::get('session_id')])->count();
            }

            //insert into cart table
           
            if($countProducts>0)
            {
                $message = "product is already exists in shopping cart!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
            //if user logged in user id will be added
            if(Auth::check())
            {
                $user_id = Auth::user()->id;
            }else
            {
                $user_id = 0;
            }

            $cart = new Cart;
            if($user_id==0)
            {
                $cart->session_id = $session_id;
            }
           else
           {
            $cart->session_id = 0;
           }
            $cart->user_id = $user_id;
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->save();
            $message = "Product Added to Cart Successfully";
            Session::flash('success_message', $message);
            return redirect()->back();
        }
    }

    //shopping cart function
    public function cart()
    {
        $userCartItems = Cart::userCartItems();
        // dd($userCartItems);
        return  view('front.products.cart')->with(compact('userCartItems'));
    }

    public function updateCartItem(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            //fetching users cart details
            $cartDetails = Cart::find($data['cartid']);
            //getting available products stock
            $availableStocks = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size']])->first()->toArray();
            // echo "qty: ".$data['qty'];
            // echo "stock: ".$availableStocks['stock']; die;
            if($data['qty']>$availableStocks['stock'])
            { 
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'product stock is not available!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))]);
            }

            $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size'],
             'status'=>1])->count();
            if($availableSize==0)
            {
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'product size is not available!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))]);

            }

            Cart::where('id', $data['cartid'])->update(['quantity'=>$data['qty']]);
            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))]);
        }
    }
    //delete cart item
    public function deleteCartItem(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            Cart::where('id',$data['cartid'])->delete();
            $totalCartItems = totalCartItems();
            $userCartItems = Cart::userCartItems();
                return response()->json([
                    'totalCartItems'=>$totalCartItems,
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))]);
        }
    }

    //apply coupon
    public function applyCoupon(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $userCartItems = Cart::userCartItems();
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();
            if($couponCount == 0)
            {
                Session::forget('couponAmount');
                $totalCartItems = totalCartItems();
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status'=>false, 
                    'totalCartItems'=>$totalCartItems,
                    'message'=>'this coupon is not valid!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))]);
            }else
            {
                //check for other coupon condition

                //get coupon details
                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();
                // echo "<pre>"; print_r($couponDetails); die;
               
                //check if coupon is inactive
                if($couponDetails->status == 0)
                {
                    $message = "Coupon is not active!";
                }

                 //check if coupon is expired
                 $expiry_date = $couponDetails->expiry_date;
                // echo "<pre>"; print_r($expiry_date);
                 $current_date = new Carbon;
                //  echo "<pre>"; print_r($current_date); die;
                 if($expiry_date < $current_date){
                     $message = 'This coupon is expired!';

                    }

                    if($couponDetails->coupon_type == "Single Time")
                    {
                        $couponCount = Order::where(['coupon_code'=> $data['code'], 'user_id'=>Auth::user()->id])->count();
                        if($couponCount >= 1)
                        {
 
                            $message = "This coupon is already used!";
                        }
                    }

        
                 //get all the categories belongs to coupon
                 $cartArr = explode(',', $couponDetails->categories);
                 //get users cart detials
                 $userCartItems = Cart::userCartItems();

                 //check if coupon belongs to logged in user
                 if(!empty($couponDetails->users))
                 {
                    $usersArr = explode(',', $couponDetails->users);
                    //get user if of all selected users
                    foreach($usersArr as $key=>$user)
                    {
                    $getUserId = User::select('id')->where('email', $user)->first()->toArray();
                    $userId[] = $getUserId['id'];
                   }
                 }
                $total_amount = 0;
                foreach($userCartItems as $key=>$item)
                {
                    // //check if coupon is from selected categories
                    if(!in_array($item['product']['category_id'], $cartArr))
                    {
                        $message = 'This coupon is not for this product';
                    }
                    //check if logged in user is selected user
                    if(!empty($couponDetails->users))
                    {
                        if(!in_array($item['user_id'], $userId))
                        {
                            $message = 'This coupon is not for you!';
                        }
                    }
                    $attrPrice = Product::getAttrDiscountedPrice($item['product_id'], $item['size']);
                    $total_amount = $total_amount + ($attrPrice['final_price'] * $item['quantity']);
                }

                if(isset($message))
                {
                    $couponAmount = 0;
                    $totalCartItems = totalCartItems();
                    $userCartItems = Cart::userCartItems();
                    return response()->json([
                        'status'=>false, 
                        'totalCartItems'=>$totalCartItems,
                        'couponAmount'=>$couponAmount,
                        'message'=>$message,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))]);
                }
                else
                {
                    if($couponDetails->amount_type == "Fixed")
                    {
                        $couponAmount = $couponDetails->amount;
                    }
                    else
                    {
                        $couponAmount = $total_amount * ($couponDetails->amount/100);
                    }
                    $grand_total = $total_amount - $couponAmount;
                    
                    // echo $couponAmount; die;
                    Session::put('couponAmount', $couponAmount);
                    Session::put('cuponCode', $data['code']);
                    $totalCartItems = totalCartItems();
                    $userCartItems = Cart::userCartItems();
                    $message = 'Coupon code successfully Applied. You are availing discount';
                    return response()->json([
                        'status'=>true, 
                        'totalCartItems'=>$totalCartItems,
                        'message'=>$message,
                        'couponAmount'=>$couponAmount,
                        'grand_total'=>$grand_total,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))]);
                }
            }
        }
    }
    //checkout 
    public function checkout(Request $request)
    {
        $userCartItems = Cart::userCartItems();
        
        if(count($userCartItems)==0)
        {
            $message = "Shopping Cart is empty! Please add products to checkout.";
            Session::put('error_message', $message);
            return redirect('/cart');
        }

        $deliveryAddresses = DeliveryAddress::deliveryAddress();
        // dd($deliveryAddresses);
        foreach($deliveryAddresses as $key=>$value)
        {
            $shippingCharge = ShippingCharge::getShippingCharge($value['country']); 
            $deliveryAddresses[$key]['shipping_charges'] = $shippingCharge;
        }
        // dd($deliveryAddresses);
        $total_price = 0;
        foreach($userCartItems as $item)
        {
            $attr_price = Product::getAttrDiscountedPrice($item['product_id'], $item['size']);
            $total_price = $total_price + $attr_price['final_price'] * $item['quantity'];
        }

        if($request->isMethod('post'))
        {
            $data = $request->all();
            if(empty($data['address_id']))
            {
                $message = "please select delivery address!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
            if(empty($data['payment_gateway']))
            {
                $message = "please select payment method!";
                Session::flash('error_message', $message);  
                return redirect()->back();
            }
            if($data['payment_gateway']=="cod")
            {
                $payment_method = "cod";
            }else
            {
               $payment_method = "khalti";
            }
            //get address using address id
            $deliveryAddress = DeliveryAddress::where('id', $data['address_id'])->first();
            //get shipping charges
            $shipping_charges = ShippingCharge::getShippingCharge($deliveryAddress['country']); 
            // dd($deliveryAddress);  
            //calculate grand total
            $grand_total = $total_price + $shipping_charges - Session::get('couponAmount');
            Session::put('grand_total', $grand_total);
            DB::beginTransaction();
            //insert data into orders table
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges;
            $order->coupon_code = Session::get('cuponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = "New";
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->save();

            //get last inserted order id
            $order_id = DB::getPdo()->lastInsertId();
            //get user cart items
            $cartItems = Cart::where('user_id', Auth::user()->id)->get()->toArray();
            foreach($cartItems as $key => $item)
            {
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;
                $getProductDetails = Product::select('product_code', 'product_name', 'product_color')->
                where('id', $item['product_id'])->first()->toArray();
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['size'];
                $get_discounted_price = Product::getAttrDiscountedPrice($item['product_id'], $item['size']);
                $cartItem->product_price = $get_discounted_price['final_price'];
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();
            }
            //empty the user cart
            Cart::where('user_id', Auth::user()->id)->delete();
            //insert order id in session variable
            Session::put('order_id', $order_id);
            DB::commit();

            if($data['payment_gateway']=="cod")
            {
                //send sms
                $message = "Dear customer, your order".$order_id."has been placed successfully and we will let you know
                once your package is on the way.";
                $mobile = Auth::user()->mobile;
                Sms::sendSms($message, $mobile);

                $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();
                // echo "<pre>"; print_r($orderDetails); die;
                //send email
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails,
                ];
                Mail::send('emails.order', $messageData, function($message) use($email){
                    $message->to($email)->subject('Order Placed E-commerce');
                });

                return redirect('/thanks');
            }
            else if($data['payment_gateway'] == "khalti")
            {
                Session::put('grand_total', $grand_total);
                return redirect('/khalti');
            }else
            {
                echo "comming soon..."; die;
            }

            echo "order placed"; die;

        }

        return view('front.products.checkout')->with(compact('userCartItems', 'deliveryAddresses', 'total_price'));
    }
    //thanks page
    public function thanks()
    {
        if(Session::has('order_id'))
        {
            Cart::where('user_id', Auth::user()->id);
            return view('front.products.thanks');
        }
        else
        {
            return redirect('/cart');
        }

    }
    //add edit delivery address
    public function addEditDeliveryAddress(Request $request, $id=null)
    {
        if($id=="")
        {
            $title = "Add Delivery Address";
            $message = "delivery address added successfully";
            $address = new DeliveryAddress;
        }
        else
        {
            $title = "Edit Delivery Address";
            $message = "delivery address updated successfully";
            $address = DeliveryAddress::find($id);
        }
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'address' => 'required',
                'city' => 'required|regex:/^[\pL\s\-]+$/u',
                'state' => 'required|regex:/^[\pL\s\-]+$/u',
                'country' => 'required',
                'pincode' => 'required|numeric|digits:5',
                'mobile' => 'required|numeric|digits:10', 
            ];
            $customMessages = [
                'name.required' => 'Name is required',
                'name.alpha' => 'Valid name is required',
                'address.required' => 'Address is required',
                'city.required' => 'City is required',
                'city.alpha' => 'Valid City name is required',
                'state.required' => 'State is required',
                'state.alpha' => 'Valid State name is required',
                'pincode.required' => 'Pincode is required',
                'pincode.numeric' => 'Valid pincode is required',
                'pincode.digits' => 'Pincode must be of 5 digits',
                'mobile.required' => 'Mobile number is required',
                'mobile.numeric' => 'Valid number is required',
                'mobile.digits' => 'Mobile number must be of 10 digits',
            ];
            $this->validate($request, $rules, $customMessages);

            $address->user_id = Auth::user()->id;
            $address->name = $data['name'];
            $address->address = $data['address'];
            $address->city = $data['city'];
            $address->state = $data['state'];
            $address->country = $data['country'];
            $address->pincode = $data['pincode'];
            $address->mobile = $data['mobile'];
            $address->status = 1;
            $address->save();
            
            Session::put('success_message', $message);
            Session::forget('error_message');
            return redirect('/checkout');
        }

        $countries = Country::where('status', 1)->get()->toArray();
        return view('front.products.add_edit_delivery_address')->with(compact('countries', 'title', 'address'));
    }
    //delete Delivery address
    public function deleteDeliveryAddress($id)
    {
        DeliveryAddress::where('id', $id)->delete();
        Session::put('success_message', 'Delivery Address deleted successfully');
        return redirect()->back();
    }

}
