<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <title>Document</title>
      <style>
         .result{
         background-color: green;
         color:#fff;
         padding:20px;
         }
         .row{
         display:flex;
         }
         #reader {
         background: black;
         width:500px;
         }
         button {
         background-color: #4CAF50; /* Green */
         border: none;
         color: white;
         padding: 10px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 16px;
         margin: 4px 2px;
         cursor: pointer;
         border-radius: 6px;
         }
         a#reader__dashboard_section_swaplink {
         background-color: blue; /* Green */
         border: none;
         color: white;
         padding: 10px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 16px;
         margin: 4px 2px;
         cursor: pointer;
         border-radius: 6px;
         }
         span a{
         display:none
         }
         #reader__camera_selection{
         background: blueviolet;
         color: aliceblue;
         }
         #reader__dashboard_section_csr span{
         color:red
         }
      </style>
   </head>
   <body>
      <div class="container">
         <!-- this function of java Script play Camera -->
         <script src="https://reeteshghimire.com.np/wp-content/uploads/2021/05/html5-qrcode.min_.js"></script>
         <!-- Header --> 
         <div class="container-fluid header_se">
            <div class="col-md-16">
               <div class="row">
                  <div class="col">
                     <div id="reader"></div>
                  </div>
               </div>
               <script type="text/javascript">
                  // after success to play camera Webcam Ajax paly to send data to Controller
                  function onScanSuccess(info) {
                  var arrayInfo = info.split(", ");
                  // console.log(array);

                  // return false;
                  $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                   type: "POST",
                   cache: false,
                   url : "/qrLogin",
                   data: {arrayInfo:arrayInfo},
                   success: function(check) {
                       // after success to get Answer from controller if User Registered login user by scanner
                       // and page change to Home blade
                    if (check==1) {
                       $(location).attr('href', '{{url('admin/dashboard')}}');
                         }
                    else{
                     return confirm('There is no user with this qr code'); 
                    }
                   }
                  })
                  }
                  var html5QrcodeScanner = new Html5QrcodeScanner(
                  "reader", { fps: 10, qrbox: 250 });
                  html5QrcodeScanner.render(onScanSuccess);
               </script>
            </div>
         </div>
      </div>
      <hr/>
   </body>
</html>