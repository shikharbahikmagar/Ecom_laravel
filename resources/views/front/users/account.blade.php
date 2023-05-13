@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">Login</li>
    </ul>
    <h3>My Account</h3>
    <hr class="soft" />
    @if(Session::has('success_message'))
                      <div class="alert alert-success" role="alert" style="margin-top: 10px;">
                    {{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  @endif
        @if(Session::has('error_message'))
            <div class="alert alert-danger" role="alert" style="margin-top: 10px;">
            {{ Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    <div class="row">
        <div class="span4">
            <div class="well">
                <h5>CREATE YOUR ACCOUNT</h5><br />
               Enter your details to create an account.<br /><br /><br />
                <form id="accountForm" action="{{ url('/account') }}" method="post">@csrf
                    <div class="control-group">
                    <label class="control-label" for="name">Name</label>
                        <div class="controls">
                            <input class="span3" type="text" name="name" id="name" 
                            placeholder="Enter your name.." value = "{{ $userDetails['name'] }}">
                        </div>
                        <label class="control-label" for="address">Address</label>
                        <div class="controls">
                            <input class="span3" type="text" name="address" id="address" 
                            placeholder="Enter your address.." value = "{{ $userDetails['address'] }}">
                        </div>
                        <label class="control-label" for="city">City</label>
                        <div class="controls">
                            <input class="span3" type="text" name="city" value = "{{ $userDetails['city'] }}" id="city" placeholder="Enter your city..">
                        </div>
                        <label class="control-label" for="state">State</label>
                        <div class="controls">
                            <input class="span3" type="text" value = "{{ $userDetails['state'] }}" name="state" id="state" placeholder="Enter your state..">
                        </div>
                        <label class="control-label" for="country">Country</label>
                        <div class="controls">
                            <select class="span3" name="country" id="country">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['country_name'] }}"
                                @if($country['country_name']==$userDetails['country'])
                                selected="" @endif>{{ $country['country_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="control-label" for="pincode">Pincode</label>
                        <div class="controls">
                            <input class="span3" type="text" value = "{{ $userDetails['pincode'] }}" name="pincode" id="pincode" placeholder="Enter your pincode..">
                        </div>
                        <label class="control-label" for="mobile">Mobile</label>
                        <div class="controls">
                        <input type="text" class="span3"  name="mobile" id="mobile" 
                        placeholder="Mobile Phone" value="{{ $userDetails['mobile'] }}"> 
                        </div>
                        <label class="control-label" for="email">E-mail address</label>
                        <div class="controls">
                            <input class="span3" type="email" name="email" id="email" 
                            placeholder="Email" value="{{ $userDetails['email'] }}" readonly="">
                        </div>
                    </div>
                    <div class="controls">
                        <button type="submit" class="btn block">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="span1"> &nbsp;</div>
        <div class="span4">
            <div class="well">
                <h5>Update Password</h5>
                <form id="passwordForm" action="{{ url('/update-user-pwd') }}" method="post">@csrf
                <div class="control-group">
                        <label class="control-label" for="current_password">Current Password</label>
                        <div class="controls">
                            <input type="text" class="span3" id="current_password" name ="current_password" placeholder="enter current password">
                            <br><span id="chkpwd"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="new_password">New Password</label>
                        <div class="controls">
                            <input type="password" class="span3" id="new_password" name ="new_password" placeholder="enter new password">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="confirm_password">Confirm Password</label>
                        <div class="controls">
                            <input type="password" class="span3" id="confirm_password" name ="confirm_password" placeholder="enter confirm password">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection