<?php  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table style="width: 700px;">  
        <tr><td>&nbsp;</td></tr>
        <tr><td>image</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Hello {{ $name }},</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Your order #{{ $order_id }} status has been updated to {{ $order_status }}.</td></tr>
        @if(!empty($courier_name) && !empty($tracking_number))
        <tr><td>&nbsp;</td></tr>
        <tr><td>Courier Name : {{ $courier_name }} <br><br> Tracking Number : {{ $tracking_number }}</td></tr>
        @endif
        <tr><td>&nbsp;</td></tr>
        <tr><td>Your order details are as below :-</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table style="width: 95%" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
            <tr bgcolor="#cccccc">
                <th>Product Name</th>
                <th>Product Code</th>
                <th>Product Size</th>
                <th>Product Color</th>
                <th>Product Quantity</th>
                <th>Product Price</th>
            </tr>
            @foreach($orderDetails['orders_products'] as $order)
            <tr>
                <td> {{ $order['product_name' ] }} </td>
                <td> {{ $order['product_code' ] }} </td>
                <td> {{ $order['product_size' ] }} </td>
                <td> {{ $order['product_color' ] }} </td>
                <td> {{ $order['product_qty' ] }} </td>
                <td> {{ $order['product_price' ] }} </td>
            </tr>
            @endforeach
            <tr>
            <td colspan="5" align="right">Shipping Charges</td>
                <td>NPR {{ $orderDetails['shipping_charges'] }}</td>
            </tr>
            <tr>
                <td colspan="5" align="right">Coupon Amount</td>
                <td>NPR 
                    @if($orderDetails['coupon_amount'] >0)
                    {{ $orderDetails['coupon_amount'] }}
                    @else
                    0
                    @endif
                    </td>
            </tr>
            <tr>
                <td colspan="5" align="right">Grand Total</td>
                <td>NPR {{ $orderDetails['grand_total'] }}</td>
            </tr>
            </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table>
                <tr>
                    <td><strong>Delivery Address :-</strong></td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['name'] }}</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['address'] }}</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['city'] }}</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['state'] }}</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['pincode'] }}</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['mobile'] }}</td>
                </tr>
            </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>For any enquiries, you can contact us at <a href="mailto:shikharbhk69@gmail.com">info@ecom.com.np</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Regards, <br>Team Code Solta</td></tr>
        <tr><td>&nbsp;</td></tr>
    </table>
</body>
</html>