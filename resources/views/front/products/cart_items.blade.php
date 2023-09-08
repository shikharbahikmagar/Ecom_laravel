<?php use App\Product;
      use App\Cart;
?>
<table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Quantity/Update</th>
                <th>Price</th>
                <th>Category/Product Discount</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $total_price = 0; ?>
            <?php $total_discount = 0; ?>
            @foreach($userCartItems as $item)
            <?php $attr_price = Product::getAttrDiscountedPrice($item['product_id'], $item['size']) ?>
            <?php $price = Cart::getProductAttrPrice($item['product_id'], $item['size']); ?>
            <tr>
                <td> <img width="60" src="{{ asset('images/product_images/small/'.$item['product']['main_image']) }}" alt="" /></td>
                <td>{{ $item['product']['product_name'] }}<br/>
                Color : {{ $item['product']['product_color'] }}<br/>
                Size : {{ $item['size'] }} <br> </td>
                <td>
                    <div class="input-append">
                        <input class="span1 totalCartItems" style="max-width:34px" value="{{$item['quantity']}}" id="appendedInputButtons" size="16" type="text">
                        <button class="btn btnItemUpdate qtyMinus" data-cartid="{{ $item['id'] }}" type="button"><i class="icon-minus"></i></button>
                        <button class="btn btnItemUpdate qtyPlus" data-cartid="{{ $item['id'] }}" type="button"><i class="icon-plus"></i></button>
                        <button class="btn btn-danger btnItemDelete" data-cartid="{{ $item['id'] }}" type="button"><i class="icon-remove icon-white"></i></button> 
                    </div>
                </td>
                <td>Rs. {{ $attr_price['product_price'] * $item['quantity'] }}</td>
                <td>Rs. -{{ $attr_price['discount'] * $item['quantity']}}</td>
                <td>Rs. {{ $attr_price['final_price'] * $item['quantity']}}</td>
                <?php $total_price = $total_price + $attr_price['final_price'] * $item['quantity']; ?>
            </tr>
            @endforeach
            <tr>
                <td colspan="5" style="text-align:right">Sub Total: </td>
                <td> Rs. {{ $total_price }}</td>
            </tr>
            <tr>
                <td colspan="5" style="text-align:right">Coupon Discount: </td>
                <td class="couponAmount">
                        Rs. 0
                </td>
            </tr>
            <tr>
                <td colspan="5" style="text-align:right"><strong>GRAND TOTAL (Rs. {{$total_price}} - <span class="couponAmount">Rs. 0</span> )
                        =</strong></td>
                <td class="label label-important" style="display:block"> <strong  class="grand_total"> Rs. {{ $grand_total = $total_price }} </strong>
                <?php Session::put('grand_total', $grand_total); ?>
                </td>
            </tr>
            
        </tbody>
</table>