<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Order;
use Session;
// reference the Dompdf namespace
use Dompdf\Dompdf;
use App\User;
use App\OrderStatus;
use App\Sms;
use App\OrdersLog;

class OrdersController extends Controller
{
    public function orders()
    {
        Session::put('page', 'orders');
        $orders = Order::with('orders_products')->orderBy('id', 'Desc')->get()->toArray();
        // dd($orders);
        return view('admin.orders.orders')->with(compact('orders'));
    }
    //admin details
    public function orderDetails($id)
    {
        $orderDetails = Order::with('orders_products')->where('id', $id)->first()->toArray();
        // dd($orderDetails);
        $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();
        $orderStatuses = OrderStatus::where('status', 1)->get()->toArray();
        $orderLog = OrdersLog::where('order_id', $id)->orderBy('id', 'Desc')->get()->toArray();
        return view('admin.orders.order_details')->with(compact('orderDetails', 'userDetails', 'orderStatuses', 'orderLog'));
    }
    //update order status
    public function updateOrderStatus(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // dd($data);
            Order::where('id', $data['order_id'])->update(['order_status'=>$data['order_status']]);
            Session::put('success_message', 'Order status has been updated successfully!');
            
            //update courier name and tracking number in orders table
            if(!empty($data['courier_name']) && !empty($data['tracking_number']))
            {
                Order::where('id', $data['order_id'])->update(['courier_name'=> $data['courier_name'], 
                'tracking_number'=>$data['tracking_number']]);
            }

            //get user mobile
            $deliveryDetails = Order::select('mobile', 'email', 'name')->where('id', $data['order_id'])->first()->toArray();
            //send sms
            $message = "Dear customer, your order status has been updated to".$data['order_status'];
            $mobile = $deliveryDetails['mobile'];
            Sms::sendSms($message, $mobile);

            $orderDetails = Order::with('orders_products')->where('id', $data['order_id'])->first()->toArray();
            // echo "<pre>"; print_r($orderDetails); die;
            //send email
            $email = $deliveryDetails['email'];
            $messageData = [
                'email' => $email,
                'name' => $deliveryDetails['name'],
                'order_id' => $data['order_id'],
                'courier_name' => $data['courier_name'],
                'tracking_number' => $data['tracking_number'],
                'order_status' => $data['order_status'],
                'orderDetails' => $orderDetails,
            ];
            Mail::send('emails.order_status', $messageData, function($message) use($email){
                $message->to($email)->subject('Order Status Updated E-commerce');
            });

            //update order logs
            $log = new OrdersLog;
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();

            return redirect()->back();
        }
    }

    public function viewOrderInvoice($id)
    {
        $orderDetails = Order::with('orders_products')->where('id', $id)->first()->toArray();
        // dd($orderDetails);
        $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();
        return view('admin.orders.order_invoice')->with(compact('orderDetails', 'userDetails'));
    }
    // printPdfInvoice
    public function printPdfInvoice($id)
    {
        $orderDetails = Order::with('orders_products')->where('id', $id)->first()->toArray();
        // dd($orderDetails);
        $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();

        $output = '
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Example 2</title>
                <link rel="stylesheet" href="style.css" media="all" />
                <style>
                    @font-face {
                    font-family: SourceSansPro;
                    src: url(SourceSansPro-Regular.ttf);
                    }
                    .clearfix:after {
                    content: "";
                    display: table;
                    clear: both;
                    }
                    a {
                    color: #0087C3;
                    text-decoration: none;
                    }
                    body {
                    position: relative;
                    width: 21cm;  
                    height: 29.7cm; 
                    margin: 0 auto; 
                    color: #555555;
                    background: #FFFFFF; 
                    font-family: Arial, sans-serif; 
                    font-size: 14px; 
                    font-family: SourceSansPro;
                    }
                    header {
                    padding: 10px 0;
                    margin-bottom: 20px;
                    border-bottom: 1px solid #AAAAAA;
                    }
                    #logo {
                    float: left;
                    margin-top: 8px;
                    }
                    #logo img {
                    height: 70px;
                    }
                    #details {
                    margin-bottom: 50px;
                    }
                    #client {
                    padding-left: 6px;
                    border-left: 6px solid #0087C3;
                    float: left;
                    }
                    #client .to {
                    color: #777777;
                    }
                    h2.name {
                    font-size: 1.4em;
                    font-weight: normal;
                    margin: 0;
                    }
                    #invoice {
                    float: right;
                    text-align: right;
                    }
                    #invoice h1 {
                    color: #0087C3;
                    font-size: 2.4em;
                    line-height: 1em;
                    font-weight: normal;
                    margin: 0  0 10px 0;
                    }
                    #invoice .date {
                    font-size: 1.1em;
                    color: #777777;
                    }
                    table {
                    width: 100%;
                    border-collapse: collapse;
                    border-spacing: 0;
                    margin-bottom: 20px;
                    }
                    table th,
                    table td {
                    padding: 20px;
                    background: #EEEEEE;
                    text-align: center;
                    border-bottom: 1px solid #FFFFFF;
                    }
                    table th {
                    white-space: nowrap;        
                    font-weight: normal;
                    }
                    table td {
                    text-align: right;
                    }
                    table td h3{
                    color: #57B223;
                    font-size: 1.2em;
                    font-weight: normal;
                    margin: 0 0 0.2em 0;
                    }
                    table .no {
                    color: #FFFFFF;
                    font-size: 1.6em;
                    background: #57B223;
                    }
                    table .desc {
                    text-align: left;
                    }
                    table .unit {
                    background: #DDDDDD;
                    }
                    table .qty {
                    }
                    table .total {
                    background: #57B223;
                    color: #FFFFFF;
                    }
                    table td.unit,
                    table td.qty,
                    table td.total {
                    font-size: 1.2em;
                    }
                    table tbody tr:last-child td {
                    border: none;
                    }
                    table tfoot td {
                    padding: 10px 20px;
                    background: #FFFFFF;
                    border-bottom: none;
                    font-size: 1.2em;
                    white-space: nowrap; 
                    border-top: 1px solid #AAAAAA; 
                    }
                    table tfoot tr:first-child td {
                    border-top: none; 
                    }
                    table tfoot tr:last-child td {
                    color: #57B223;
                    font-size: 1.4em;
                    border-top: 1px solid #57B223; 
                    }
                    table tfoot tr td:first-child {
                    border: none;
                    }

                </style>
            </head>
            <body>
                <header class="clearfix">
                    <div id="logo">
                    <h1>Order Invoice</h1>

                    </div>
                    </div>
                </header>
                <main>
                    <div id="details" class="clearfix">
                        <div id="client">
                            <div class="to">INVOICE TO:</div>
                            <h2 class="name">'.$orderDetails['name'].'</h2>
                            <div class="address">'.$orderDetails['address'].','.$orderDetails['city'].','.$orderDetails['state'].'</div>
                            <div class="address">'.$orderDetails['country'].','.$orderDetails['pincode'].'</div>
                            <div class="email"><a href="mailto:'.$orderDetails['email'].'">'.$orderDetails['email'].'</a></div>
                        </div>
                        <div id="invoice">
                            <h1>Order ID: '.$orderDetails['id'].'</h1>
                            <div class="date">Order Date: '.date('d-m-Y', strtotime($orderDetails['created_at'])).'</div>
                            <div class="date">Order Amount: '.$orderDetails['grand_total'].'</div>
                            <div class="date">Order Date: '.$orderDetails['created_at'].'</div>
                            <div class="date">Payment Method: '.$orderDetails['payment_method'].'</div>
        
                        </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th class="desc">Product code</th>
                                <th class="desc">Size</th>
                                <th class="unit">Color</th>
                                <th class="qty">Price</th>
                                <th class="qty">Qty</th>
                                <th class="total">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>';
                            $sub_total = 0;
                        foreach($orderDetails['orders_products'] as $product)
                        {
                            $output .= '<tr>
                                <td class="no">'.$product['product_code'].'</td>
                                <td class="desc">'.$product['product_size'].'</td>
                                <td class="unit">'.$product['product_color'].'</td>
                                <td class="qty">'.$product['product_price'].'</td>
                                <td class="qty">'.$product['product_qty'].'</td>
                                <td class="total">Rs. '.$product['product_price'] * $product['product_qty'].'</td>
                            </tr>';
                            $sub_total = $sub_total + ($product['product_price'] * $product['product_qty']);
                        }
                       $output .= '</tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">SUBTOTAL</td>
                                <td>'.$sub_total.'</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">Shipping Charges</td>
                                <td>Rs. 0</td>
                            </tr>
                            <tr>
                            <td colspan="2"></td>
                            <td colspan="2">Coupon Discount</td>';
                            if($orderDetails['coupon_amount']>0)
                            {
                                $output .= '<td>Rs. '.$orderDetails['coupon_amount'].'</td>';
                            }
                            else
                            {
                                $output .= '<td>Rs. 0</td>';
                            }
                            
                        $output .= '</tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">GRAND TOTAL</td>
                                <td>Rs. '.$orderDetails['grand_total'].'</td>
                            </tr>
                        </tfoot>
                    </table>
                </main>
                <br>
                <footer>
                <hr><br>
                  <p style="color:black; text-align:center;">Invoice was created on a computer and is valid without the signature and seal.</p>
                </footer>
            </body>
        </html>';
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($output);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
        return view('admin.orders.order_invoice')->with(compact('orderDetails', 'userDetails'));
    }

}
