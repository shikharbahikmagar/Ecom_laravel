$(document).ready(function()
{
    $('#current_pwd').keyup(function()
    {
        var current_pwd = $('#current_pwd').val();
        // alert (current_pwd);
        $.ajax({
            type : 'post',
            url : '/admin/check-current-pwd',
            data : {current_pwd:current_pwd},
            success:function(resp)
            {
                if(resp=="false")
                {
                    $("#chkCurrentPwd").html("<font color=red>password is incorrect</font>");
                }else
                {
                    $("#chkCurrentPwd").html("<font color=green>password is correct</font>");
                }
            }, error:function()
            {
                alert("error");
            }
        });
    });

    //update section status

        // $(".updateSectionStatus").click(function()
        $(document).on("click", ".updateSectionStatus", function()
        {
            var status = $(this).children("i").attr("status");
            var section_id = $(this).attr("section_id");
            // alert(status);
            // alert(section_id);
            $.ajax({
                type: 'post',
                url : '/admin/update-section-status',
                data : {status:status, section_id:section_id},
                success:function(resp)
                {
                    if(resp['status']==0)
                    {
                        $("#section-"+section_id).html(" <i class='fas fa-toggle-off' aria-hidden='true' status='In-Active'></i>");
                    }
                    else if(resp['status']==1)
                    {
                        $("#section-"+section_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                    }
                }, error:function()
                {
                    alert("error");
                }
            });
        });
        

        //update category status
        // $(".updateCategoryStatus").click(function()
        $(document).on("click", ".updateCategoryStatus", function()
        {
            var status = $(this).children("i").attr("status");
            var category_id = $(this).attr("category_id");
            // alert(status);
            // alert(category_id);
            $.ajax({
                type: 'post',
                url : '/admin/update-category-status',
                data : {status:status, category_id:category_id},
                success:function(resp)
                {
                    if(resp['status']==0)
                    {
                        $("#category-"+category_id).html(" <i class='fas fa-toggle-off' aria-hidden='true' status='In-Active'></i>");
                    }
                    else if(resp['status']==1)
                    {
                        $("#category-"+category_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                    }
                }, error:function()
                {
                    alert("error");
                }
            });
        });

        //append category level
        $('#section_id').change(function(){
            var section_id = $(this).val();
            // alert (section_id);
            $.ajax({
                type : 'post',
                url : '/admin/append-categories-level',
                data : {section_id:section_id},
                success:function(resp)
                {
                    $('#appendCategoryLevel').html(resp);
                }, error:function()
                {
                    alert("error");
                }

            });
        });

        //sweet alert 2 delete Category table
    //    $('.confirmDelete').click(function(){
        $(document).on("click", ".confirmDelete", function(){
        var record = $(this).attr("record");
        var recordId = $(this).attr("recordId");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
                window.location.href="/admin/delete-"+record+"/"+recordId; 

            }
          });

       });

       //delete category image sweet alert
    //    $('.imageConfirmDelete').click(function(){
        $(document).on("click", ".imageConfirmDelete", function(){
        var record = $(this).attr("record");
        var recordId = $(this).attr("recordId");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
                window.location.href="/admin/delete-"+record+"/"+recordId; 

            }
          });

       });

       //update product status
    //    $('.updateProductStatus').click(function(){
        $(document).on("click", ".updateProductStatus", function()
        {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-product-status',
            data: {status:status, product_id:product_id},
            success:function(resp){
                if(resp['status']==0)
                {
                    $('#product-'+product_id).html(" <i class='fas fa-toggle-off' aria-hidden='true' status='In-Active'></i>");
                }else if(resp['status']==1)
                {
                    $('#product-'+product_id).html(" <i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error:function()
            {
                alert("error");
            }

        });

       });

       //delete product table
    //    $('.confirmDelete').click(function(){
        $(document).on("click", ".confirmDelete", function(){
        var record = $(this).attr("record");
        var recordId = $(this).attr("recordId");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
                window.location.href="/admin/delete-"+record+"/"+recordId; 

            }
          });

       });

         //delete category image sweet alert
        //  $('.imageConfirmDelete').click(function(){
            $(document).on("click", ".imageConfirmDelete", function(){
            var record = $(this).attr("record");
            var recordId = $(this).attr("recordId");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                    window.location.href="/admin/delete-"+record+"/"+recordId; 
    
                }
              });
    
           });

        //delete product video sweet alert
        //  $('.videoConfirmDelete').click(function(){
            $(document).on("click", ".videoConfirmDelete", function(){
            var record = $(this).attr("record");
            var recordId = $(this).attr("recordId");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                    window.location.href="/admin/delete-"+record+"/"+recordId; 
    
                }
              });
    
           });

           //add remove products attributes dynamically
           var maxField = 10; //Input fields increment limitation
           var addButton = $('.add_button'); //Add button selector
           var wrapper = $('.field_wrapper'); //Input field wrapper
           var fieldHTML = '<div style="margin-top:2px;"><input type="text" id="size" name="size[]" value="" placeholder="size" style="width:120px;"/>&nbsp;<input type="number" id="price" name="price[]" value="" placeholder="price" style="width:120px;"/>&nbsp;<input type="number" id="stock" name="stock[]" value="" placeholder="stock" style="width:120px;"/>&nbsp;<input type="text" id="sku" name="sku[]" value="" placeholder="sku" style="width:120px;"/><a href="javascript:void(0);" class="remove_button">&nbsp;Remove</a></div>'; //New input field html 
           var x = 1; //Initial field counter is 1
           
           //Once add button is clicked
           $(addButton).click(function(){
               //Check maximum number of input fields
               if(x < maxField){ 
                   x++; //Increment field counter
                   $(wrapper).append(fieldHTML); //Add field html
               }
           });
           
           //Once remove button is clicked
           $(wrapper).on('click', '.remove_button', function(e){
               e.preventDefault();
               $(this).parent('div').remove(); //Remove field html
               x--; //Decrement field counter
           });

        //update product attributes status
    //    $('.updateProductAttributeStatus').click(function(){
        $(document).on("click", ".updateProductAttributeStatus", function()
        {
        var status = $(this).children("i").attr("status");
        var attribute_id = $(this).attr("attribute_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-attribute-status',
            data: {status:status, attribute_id:attribute_id},
            success:function(resp){
                if(resp['status']==0)
                {
                    $('#attribute-'+attribute_id).html("  <i class='fas fa-toggle-off' aria-hidden='true' status='In-Active'></i>");
                }else if(resp['status']==1)
                {
                    $('#attribute-'+attribute_id).html("  <i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                }
            }, error:function()
            {
                alert("error");
            }

        });

       });

       //delete attribute table row
    //    $('.confirmAttributeDelete').click(function(){
        $(document).on("click", ".confirmAttributeDelete", function(){
        var record = $(this).attr("record");
        var recordId = $(this).attr("recordId");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
                window.location.href="/admin/delete-"+record+"/"+recordId; 

            }
          });

       });

         //update products images status
        //  $(".updateProductImagesStatus").click(function()
        $(document).on("click", ".updateProductImagesStatus", function()
         {
             var status = $(this).children("i").attr("status");
             var image_id = $(this).attr("image_id");
             // alert(status);
             $.ajax({
                 type: 'post',
                 url : '/admin/update-product-image-status',
                 data : {status:status, image_id:image_id},
                 success:function(resp)
                 {
                     if(resp['status']==0)
                     {
                         $("#image-"+image_id).html("  <i class='fas fa-toggle-off' aria-hidden='true' status='In-Active'></i>");
                     }
                     else if(resp['status']==1)
                     {
                         $("#image-"+image_id).html("  <i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
                     }
                 }, error:function()
                 {
                     alert("error");
                 }
             });
         });
         //confirmImageDelete
        //  $('.confirmImageDelete').click(function(){
            $(document).on("click", ".confirmImageDelete", function(){
            var record = $(this).attr("record");
            var recordId = $(this).attr("recordId");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                    window.location.href="/admin/delete-"+record+"/"+recordId; 
    
                }
              });
    
           });

           //UPDATE brand status

        //    $(".updateBrandStatus").click(function()
           $(document).on("click", ".updateBrandStatus", function()
           {
               var status = $(this).children("i").attr("status");
               var brand_id = $(this).attr("brand_id");
               $.ajax({
                   type: 'post',
                   url : '/admin/update-brand-status',
                   data : {status:status, brand_id:brand_id},
                   success:function(resp)
                   {
                       if(resp['status']==0)
                       {
                           $("#brand-"+brand_id).html(" <i class='fas fa-toggle-off' aria-hidden='true' status='In-Active'></i>");
                       }
                       else if(resp['status']==1)
                       {
                           $("#brand-"+brand_id).html("  <i class='fas fa-toggle-on' aria-hidden='true' status='In-Active'></i>");
                       }
                   }, error:function()
                   {
                       alert("error");
                   }
               });
           });

    //confirmBrandDelete
    // $('.confirmBrandDelete').click(function(){
        $(document).on("click", ".confirmBrandDelete", function(){
        var record = $(this).attr("record");
        var recordId = $(this).attr("recordId");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
                window.location.href="/admin/delete-"+record+"/"+recordId; 

            }
          });

       });

       //updateBannerStatus
           $(document).on("click", ".updateBannerStatus", function()
           {
               var status = $(this).children("i").attr("status");
               var banner_id = $(this).attr("banner_id");
               $.ajax({
                   type: 'post',
                   url : '/admin/update-banner-status',
                   data : {status:status, banner_id:banner_id},
                   success:function(resp)
                   {
                       if(resp['status']==0)
                       {
                           $("#banner-"+banner_id).html(" <i class='fas fa-toggle-off' aria-hidden='true' status='In-Active'></i>");
                       }
                       else if(resp['status']==1)
                       {
                           $("#banner-"+banner_id).html("  <i class='fas fa-toggle-on' aria-hidden='true' status='In-Active'></i>");
                       }
                   }, error:function()
                   {
                       alert("error");
                   }
               });
           });

        //delete banner 
        $(document).on("click", ".confirmDelete", function(){
            var record = $(this).attr("record");
            var recordId = $(this).attr("recordId");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                    window.location.href="/admin/delete-"+record+"/"+recordId; 
    
                }
              });
    
           });

            //  $('.confirmImageDelete').click(function(){
            $(document).on("click", ".confirmImageDelete", function(){
            var record = $(this).attr("record");
            var recordId = $(this).attr("recordId");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                    window.location.href="/admin/delete-"+record+"/"+recordId; 
    
                }
              });
    
        });
            //updateCouponStatus
            $(document).on("click", ".updateCouponStatus", function()
            {
                var status = $(this).children("i").attr("status");
                var coupon_id = $(this).attr("coupon_id");
                $.ajax({
                    type: 'post',
                    url : '/admin/update-coupon-status',
                    data : {status:status, coupon_id:coupon_id},
                    success:function(resp)
                    {
                        if(resp['status']==0)
                        {
                            $("#coupon-"+coupon_id).html(" <i class='fas fa-toggle-off' aria-hidden='true' status='In-Active'></i>");
                        }
                        else if(resp['status']==1)
                        {
                            $("#coupon-"+coupon_id).html("  <i class='fas fa-toggle-on' aria-hidden='true' status='In-Active'></i>");
                        }
                    }, error:function()
                    {
                        alert("error");
                    }
                });
            });
        //delete coupon
        $(document).on("click", ".confirmDelete", function(){
        var record = $(this).attr("record");
        var recordId = $(this).attr("recordId");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
                window.location.href="/admin/delete-"+record+"/"+recordId; 

            }
            });

        });
        //show/hide coupon field for automaic/manual
        $("#automaticCoupon").click(function(){
            $("#couponField").hide();
        });

        $("#manualCoupon").click(function(){
            $("#couponField").show();
        });
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        //Money Euro
        $('[data-mask]').inputmask()

        //for courier name and tracking number
        $("#courier_name").hide();
        $("#tracking_number").hide();

        $("#order_status").on("change", function(){
            // alert(this.value);
            if(this.value=="Shipped")
            {
                $("#courier_name").show();
                $("#tracking_number").show();
            }
            else
            {
                $("#courier_name").hide();
                $("#tracking_number").hide();
            }
        });

         //update Shipping Charge Status
         $(document).on("click", ".updateShippingStatus", function()
         {
             var status = $(this).children("i").attr("status");
             var shipping_id = $(this).attr("shipping_id");
             $.ajax({
                 type: 'post',
                 url : '/admin/update-shipping-status',
                 data : {status:status, shipping_id:shipping_id},
                 success:function(resp)
                 {
                     if(resp['status']==0)
                     {
                         $("#shipping-"+shipping_id).html(" <i class='fas fa-toggle-off' aria-hidden='true' status='In-Active'></i>");
                     }
                     else if(resp['status']==1)
                     {
                         $("#shipping-"+shipping_id).html("  <i class='fas fa-toggle-on' aria-hidden='true' status='In-Active'></i>");
                     }
                 }, error:function()
                 {
                     alert("error");
                 }
             });
         });
});