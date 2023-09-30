<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Stack Developers E-commerce Website</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- Front style --> 
      <link id="callCss" rel="stylesheet" href="themes/css/front.min.css" media="screen"/>
      <link href="themes/css/base.css" rel="stylesheet" media="screen"/>
      <!-- Front style responsive -->	
      <link href="themes/css/front-responsive.min.css" rel="stylesheet"/>
      <link href="themes/css/font-awesome.css" rel="stylesheet" type="text/css">
      <!-- Google-code-prettify -->	
      <link href="themes/js/google-code-prettify/prettify.css" rel="stylesheet"/>
      <!-- fav and touch icons -->
      <link rel="shortcut icon" href="themes/images/ico/favicon.ico">
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="themes/images/ico/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="themes/images/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="themes/images/ico/apple-touch-icon-72-precomposed.png">
      <link rel="apple-touch-icon-precomposed" href="themes/images/ico/apple-touch-icon-57-precomposed.png">
      <style type="text/css" id="enject"></style>
   </head>
   <body>
	@include('layouts.front_layout.front_header');
      <!-- Header End====================================================================== -->
      <div id="mainBody">
         <div class="container">
                  @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('success_message'))
                <div class="alert alert-success" role="alert" style="margin-top: 10px;">
                    {{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php Session::forget('success_message') ?>
        @endif
        @if(Session::has('error_message'))
            <div class="alert alert-danger" role="alert" style="margin-top: 10px;">
            {{ Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <?php Session::forget('error_message') ?>
        @endif
            <hr class="soften">
            <h1>Visit us</h1>
            <hr class="soften"/>
            <div class="row">
               <div class="span4">
                  <h4>Contact Details</h4>
                  <p>	Bijaypur-26,<br/> 33700, Lekhnath
                     <br/><br/>
                    merokapada.np@gmail.com<br/>
                     ﻿Tel 9864894574<br/>
                     Fax 2164-9847<br/>
                     web: merokapada.com.np
                  </p>
               </div>
               <div class="span4">
                  <h4>Store Opening Hours</h4>
                  <h5> Sunday - Friday</h5>
                  <p>05:00am - 09:00pm<br/><br/></p>
                  <h5>Saturday</h5>
                  <p>10:00am - 04:00pm<br/><br/></p>
               </div>
               <div class="span4">
                  <h4>Email Us</h4>
                  <form class="form-horizontal" method="post" action="{{ url('/send-mail') }}">@csrf
                     <fieldset>
                        <div class="control-group">
                           <input type="text" placeholder="name" name="name" class="input-xlarge" required = ""/>
                        </div>
                        <div class="control-group">
                           <input type="email" required = "" placeholder="email" name="email" class="input-xlarge"/>
                        </div>
                        <div class="control-group">
                           <input type="text" required = "" placeholder="subject" name="subject" class="input-xlarge"/>
                        </div>
                        <div class="control-group">
                           <textarea rows="3" id="textarea" required = "" name="message" class="input-xlarge"></textarea>
                        </div>
                        <button class="btn btn-large" type="submit">Send Messages</button>
                     </fieldset>
                  </form>
               </div>
            </div>
            <div class="row">
               <div class="span12">
                  <iframe style="width:100%; height:300; border: 0px" scrolling="no" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7033.065461207195!2d84.02591589361896!3d28.191122853634514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399596133c1d8a73%3A0x8f88f94677445e4f!2sBijayapur%2C%20Lekhnath%2033700!5e0!3m2!1sen!2snp!4v1696040939916!5m2!1sen!2snp"></iframe><br />
               </div>
            </div>
         </div>
      </div>
      <!-- MainBody End ============================= -->
      <!-- Footer ================================================================== -->
      <div  id="footerSection">
         <div class="container">
            <div class="row">
               <div class="span3">
                  <h5>ACCOUNT</h5>
                  <a href="login.html">YOUR ACCOUNT</a>
                  <a href="login.html">PERSONAL INFORMATION</a>
                  <a href="login.html">ORDER HISTORY</a>
               </div>
               <div class="span3">
                  <h5>INFORMATION</h5>
                  <a href="contact.html">CONTACT</a>
                  <a href="tac.html">TERMS AND CONDITIONS</a>
                  <a href="faq.html">FAQ</a>
               </div>
               <div class="span3">
                  <h5>OUR OFFERS</h5>
                  <a href="#">NEW PRODUCTS</a>
                  <a href="#">TOP SELLERS</a>
                  <a href="special_offer.html">SPECIAL OFFERS</a>
               </div>
               <div id="socialMedia" class="span3 pull-right">
                  <h5>SOCIAL MEDIA </h5>
                  <a href="https://www.facebook.com/groups/stackdevelopers"><img width="60" height="60" src="themes/images/facebook.png" title="facebook" alt="facebook"/></a>
                  <a href="#"><img width="60" height="60" src="themes/images/twitter.png" title="twitter" alt="twitter"/></a>
                  <a href="https://www.youtube.com/StackDevelopers"><img width="60" height="60" src="themes/images/youtube.png" title="youtube" alt="youtube"/></a>
               </div>
            </div>
            <p class="pull-right">&copy; Stack Developers</p>
         </div>
         <!-- Container End -->
      </div>
      <!-- Placed at the end of the document so the pages load faster ============================================= -->
      <script src="themes/js/jquery.js" type="text/javascript"></script>
      <script src="themes/js/front.min.js" type="text/javascript"></script>
      <script src="themes/js/google-code-prettify/prettify.js"></script>
      <script src="themes/js/front.js"></script>
      <script src="themes/js/jquery.lightbox-0.5.js"></script>
   </body>
</html>