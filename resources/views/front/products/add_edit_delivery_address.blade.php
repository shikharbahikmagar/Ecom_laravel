@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
        <li class="active">Delivery Address</li>
    </ul>
    <h3>Add Delivery Address</h3>
    <hr class="soft" />
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
               Enter your delivery details.<br /><br />
                <form @if(empty($address['id'])) action="{{ url('/add-edit-delivery-address') }}"
                 @else  action="{{ url('/add-edit-delivery-address/'.$address['id']) }}" @endif method="post">@csrf
                    <div class="control-group">
                    <label class="control-label" for="name">Name</label>
                        <div class="controls">
                            <input class="span3" type="text" name="name" id="name" @if(isset($address['name'])) 
                            value="{{ $address['name'] }}" @else value="{{ old('name') }}" @endif placeholder="Enter your name..">
                        </div>
                        <label class="control-label" for="address">Address</label>
                        <div class="controls">
                            <input class="span3" type="text" name="address" id="address" @if(isset($address['address'])) 
                            value="{{ $address['address'] }}" @else value="{{ old('address') }}" @endif
                            placeholder="Enter your address..">
                        </div>
                        <label class="control-label" for="city">City</label>
                        <div class="controls">
                            <input class="span3" type="text" name="city" id="city" placeholder="Enter your city.."
                            @if(isset($address['city'])) value="{{ $address['city'] }}" @else value="{{ old('city') }}" @endif>
                        </div>
                        <label class="control-label" for="state">State</label>
                        <div class="controls">
                            <input class="span3" type="text" name="state" id="state" placeholder="Enter your state.."
                            @if(isset($address['state'])) value="{{ $address['state'] }}" @else value="{{ old('state') }}" @endif>
                        </div>
                        <label class="control-label" for="country">Country</label>
                        <div class="controls">
                            <select class="span3" name="country" id="country">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['country_name'] }}" @if($country['country_name'] == $address['country'] )
                                selected="" @elseif($country['country_name'] == old('country') )
                                selected="" @endif>{{ $country['country_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="control-label" for="pincode">Pincode</label>
                        <div class="controls">
                            <input class="span3" type="text" name="pincode" id="pincode" placeholder="Enter your pincode.."
                            @if(isset($address['pincode'])) value="{{ $address['pincode'] }}" @else value="{{ old('pincode') }}" @endif>
                        </div>
                        <label class="control-label" for="mobile">Mobile</label>
                        <div class="controls">
                        <input type="text" class="span3"  name="mobile" id="mobile" @if(isset($address['mobile'])) 
                            value="{{ $address['mobile'] }}" @else value="{{ old('mobile') }}" @endif
                        placeholder="Mobile Phone"> 
                        </div>
                    </div>
                    <div class="controls">
                        <button type="submit" class="btn block">Submit</button>
                        <a href="{{ url('/checkout') }}" class="btn block">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection