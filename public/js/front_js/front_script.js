$(document).ready(function(){
    
    $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
     });
//     $("#sort").on('change', function(){
//         this.form.submit(); 
//    });

    $("#sort").on('change', function(){
        var fabric = get_filter("fabric");
        var pattern = get_filter("pattern");
        var sleeve = get_filter("sleeve");
        var fit = get_filter("fit");
        var occasion = get_filter("occasion");
        var sort = $(this).val();
        var url = $("#url").val();
        // alert(url);
            $.ajax({
                url: url,
                method: "post",
                data: {occasion:occasion, fit:fit, sleeve:sleeve, pattern:pattern, fabric:fabric, sort:sort, url:url},
                success:function(data)
                {
                    $('.filter_products').html(data);
                }
            });
    });

    //fabric
    $(".fabric").on('click', function(){
        
        var pattern = get_filter("pattern");
        var sleeve = get_filter("sleeve");
        var fit = get_filter("fit");
        var occasion = get_filter("occasion");
        var fabric = get_filter(this);
        var sort = $("#sort option:selected").val();
        var url = $("#url").val();
        $.ajax({

            url:url,
            method: "post",
            data:{occasion:occasion, fit:fit, sleeve:sleeve, pattern:pattern, fabric:fabric, sort:sort, url:url},
            success:function(data)
            {
                $('.filter_products').html(data);
            }


        })
    });
    //Pattern
    $(".pattern").on('click', function(){
        var fabric = get_filter("fabric");
        var sleeve = get_filter("sleeve");
        var fit = get_filter("fit");
        var occasion = get_filter("occasion");
        var pattern = get_filter(this);
        var sort = $("#sort option:selected").val();
        var url = $("#url").val();
        $.ajax({

            url:url,
            method: "post",
            data:{occasion:occasion, fit:fit, sleeve:sleeve, pattern:pattern, fabric:fabric, sort:sort, url:url},
            success:function(data)
            {
                $('.filter_products').html(data);
            }


        })
    });
    //sleeve
        $(".sleeve").on('click', function(){
            var fabric = get_filter("fabric");
            var pattern = get_filter("pattern");
            var fit = get_filter("fit");
            var occasion = get_filter("occasion");
            var sleeve = get_filter(this);
            var sort = $("#sort option:selected").val();
            var url = $("#url").val();
            $.ajax({
    
                url:url,
                method: "post",
                data:{occasion:occasion, fit:fit, sleeve:sleeve, pattern:pattern, fabric:fabric, sort:sort, url:url},
                success:function(data)
                {
                    $('.filter_products').html(data);
                }
    
    
            })
        });
        //fit
        $(".fit").on('click', function(){
            var fabric = get_filter("fabric");
            var pattern = get_filter("pattern");
            var sleeve = get_filter("sleeve");
            var occasion = get_filter("occasion");
            var fit = get_filter(this);
            var sort = $("#sort option:selected").val();
            var url = $("#url").val();
            $.ajax({
    
                url:url,
                method: "post",
                data:{occasion:occasion, fit:fit, sleeve:sleeve, pattern:pattern, fabric:fabric, sort:sort, url:url},
                success:function(data)
                {
                    $('.filter_products').html(data);
                }
    
    
            })
        });
        //occasion
                //fit
        $(".fit").on('click', function(){
            var fabric = get_filter("fabric");
            var pattern = get_filter("pattern");
            var sleeve = get_filter("sleeve");
            var occasion = get_filter("occasion");
            var fit = get_filter(this);
            var sort = $("#sort option:selected").val();
            var url = $("#url").val();
            $.ajax({
    
                url:url,
                method: "post",
                data:{occasion:occasion, fit:fit, sleeve:sleeve, pattern:pattern, fabric:fabric, sort:sort, url:url},
                success:function(data)
                {
                    $('.filter_products').html(data);
                }
    
    
            })
        });
        //occasion
        $(".occasion").on('click', function(){
            var fabric = get_filter("fabric");
            var pattern = get_filter("pattern");
            var sleeve = get_filter("sleeve");
            var fit = get_filter("fit");
            var occasion = get_filter(this);
            var sort = $("#sort option:selected").val();
            var url = $("#url").val();
            $.ajax({
    
                url:url,
                method: "post",
                data:{occasion:occasion, fit:fit, sleeve:sleeve, pattern:pattern, fabric:fabric, sort:sort, url:url},
                success:function(data)
                {
                    $('.filter_products').html(data);
                }
    
    
            })
        });        

    //function that all classes use
    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    //showing price according to size 
    $("#getPrice").change(function(){
        var size = $(this).val();
        if(size=="")
        {
            alert("please select size!");
            return false;
        }
        var product_id = $(this).attr("product-id");
        /*alert(product_id);*/
        $.ajax({
            url:'/getting-product-price',
            data:{size:size, product_id:product_id},
            type:'post',
            success:function(resp){
                // alert(resp['product_price']); 
                // alert(resp['discounted_price']);return false;
                if(resp['discount']>0)
                {
                    $(".getAttrPrice").html("<del> Rs. "+resp['product_price']+"</del> Rs. "+resp['final_price']);
                }   
                else
                {
                    $(".getAttrPrice").html("Rs. "+resp['product_price']);   
                }
            }, error:function()
            {
                alert("error");
            }

        });
    });

    //plus minus cart item
    $(document).on('click','.btnItemUpdate',function(){
		if($(this).hasClass('qtyMinus')){
			// if qtyMinus button gets clicked by User
			var quantity = $(this).prev().val();
			if(quantity<=1){
				alert("Item quantity must be 1 or greater!");
				return false;
			}else{
				new_qty = parseInt(quantity)-1;
			}
		}
		if($(this).hasClass('qtyPlus')){
			// if qtyPlus button gets clicked by User
			var quantity = $(this).prev().prev().val();
			new_qty = parseInt(quantity)+1;
		}
		var cartid = $(this).data('cartid');
		$.ajax({
			data:{"cartid":cartid,"qty":new_qty},
			url:'/update-cart-item-qty',
			type:'post',
			success:function(resp){
				if(resp.status==false){
					alert(resp.message);
				}
                // alert(resp.totalCartItems);
				$(".totalCartItems").html(resp.totalCartItems);
				$("#AppendCartItems").html(resp.view);
			},error:function(){
				alert("Error");
			}
		});
	});
    //delete cart item
     $(document).on('click','.btnItemDelete',function(){
		var cartid = $(this).data('cartid');
        var display = confirm("Want to delete this Cart Item?");
        if(display){
            $.ajax({
                data:{"cartid":cartid},
                url:'/delete-cart-item',
                type:'post',
                success:function(resp){
                    $(".totalCartItems").html(resp.totalCartItems);
                    $("#AppendCartItems").html(resp.view);
                },error:function(){
                    alert("Error");
                }
            });
        }

	});
    //register form validation
	$("#registerForm").validate({
        rules: {
            name: "required",
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true
            },
            email: {
                required: true,
                email: true,
                remote: "check-email"
            },
            password: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            name: "Please enter your name",
            mobile: {
                required: "Please enter a mobile number",
                minlength: "enter at least 10 digits",
                maxlength: "enter at most 10 digits",
                digit: "enter valid number"
            },
            email: {
                required: "email is required",
                email: "Please enter a valid email address",
                remote: "email already exists",
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
        }
    });
    //login form validation
	$("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            email: {
                required: "email is required",
                email: "Please enter a valid email address",
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
        }
    });

        //account form validation
	$("#accountForm").validate({
        rules: {
            name: {
                required: true,
                lettersonly: true
            },
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true
        }
        },
        messages: {
            name: "Please enter your name",
            mobile: {
                required: "Please enter a mobile number",
                minlength: "enter at least 10 digits",
                maxlength: "enter at most 10 digits",
                digit: "enter valid number"
            }
        }
    });

    //check current password 
    $("#current_password").keyup(function(){
        var current_pwd = $(this).val();
        $.ajax({
            type: 'post',
            url: '/check-user-pwd',
            data: {current_pwd:current_pwd},
            success:function(resp)
            {
                if(resp=="false")
                {
                    $("#chkpwd").html("<font color=red>password is incorrect</font>");
                }else
                {
                    $("#chkpwd").html("<font color=green>password is correct</font>");
                }
            }, error:function()
            {
                alert("error");
            }
        });
    });
    //password Form
    $("#passwordForm").validate({
        rules: 
        {
            current_password: 
            {
                required: true,
                minlength: 8,
                maxlength: 20,
            },

            new_password: 
            {
                required: true,
                minlength: 8,
                maxlength: 20,
            },    

            confirm_password: 
            {
                required: true,
                minlength: 8,
                maxlength: 20,
                equalTo: "#new_password"
            }
        }
    });
    //apply coupon
    $("#ApplyCoupon").submit(function(){
        var user = $(this).attr("user");
        if(user==1)
        {

        }
        else
        {
            alert("please login to apply coupon.");
            return false;
        }
        var code = $("#code").val();
        $.ajax({
            type:"post",
            data:{code:code},
            url: "/apply-coupon",
            success:function(resp)
            {
                if(resp.message!="")
                {
                    alert(resp.message);
                }
                $(".totalCartItems").html(resp.totalCartItems);
                $("#AppendCartItems").html(resp.view);
                if(resp.couponAmount>=0){
                    $(".couponAmount").text("Rs. " + resp.couponAmount);
                }
                else{
                    $(".couponAmount").text("Rs. 0");
                }
               if(resp.grand_total>=0)
               {

                $(".grand_total").text("Rs. " + resp.grand_total);
               }  
            }, error:function()
            {
                alert("error");
            }
        });
    });

    //confirm delete delivery address
    $(document).on('click', '.addressDelete', function(){
        var result = confirm("Want to delete this address?");
        if(!result)
        {
            return false;
        }
    })
    //calculate shipping charges and update grand total
    $("input[name=address_id]").bind('change', function(){
        var shipping_charges = $(this).attr("shipping_charges");
        var total_price = $(this).attr("total_price");
        var couponAmount = $(this).attr("coupon_amount");
        if(couponAmount == "")
        {
            var couponAmount = 0;
        }
        $(".shipping_charges").html("Rs. "+shipping_charges);
        var grand_total = parseInt(total_price) + parseInt(shipping_charges) - parseInt(couponAmount);
        $(".grand_total").html("Rs. "+grand_total);
    });

    //khalti
    var product_code = document.getElementById("product_code").value;
    var product_name = document.getElementById("product_name").value;
    var product_id = document.getElementById("product_id").value;
    var config = {
    // replace the publicKey with yours
    "publicKey": "test_public_key_f8613819832a479c847ecdfb68e41aa4",
    "productIdentity": product_code,
    "productName": product_name,
    "productUrl": '/product/'+product_id,
    "paymentPreference": [
    "KHALTI",
    "EBANKING",
    "MOBILE_BANKING",
    "CONNECT_IPS",
    "SCT",
    ],
    "eventHandler": {
    onSuccess (payload) {
        // hit merchant api for initiating verfication
        console.log(payload);
    },
    onError (error) {
        console.log(error);
    },
    onClose () {
        console.log('widget is closing');
    }
    }
    };
    var grand_total = document.getElementById("grand_total").value;
    var checkout = new KhaltiCheckout(config);
    var btn = document.getElementById("payment-button");
    btn.onclick = function () {
    var grand_total = document.getElementById("grand_total").value;
    // minimum transaction amount must be 10, i.e 1000 in paisa.
    checkout.show({amount: grand_total*100 });
    }
});