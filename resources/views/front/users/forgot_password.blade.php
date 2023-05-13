@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">Forgot Password</li>
    </ul>
    <h3>Forgot Password</h3>
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
    <div class="row">
        <div class="span4">
            <div class="well">
                <h5>Forgot Password?</h5><br />
               Enter your your email to get the new password.<br /><br /><br />
                <form action="{{ url('/forgot-password') }}" method="post">@csrf
                    <div class="control-group">
                        <label class="control-label" for="email">Email</label>
                        <div class="controls">
                            <input class="span3" type="email" name="email" id="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="controls">
                        <button type="submit" class="btn block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="span1"> &nbsp;</div>
        <div class="span4">
            <div class="well">
                <h5>ALREADY REGISTERED ?</h5>
                <form id="loginForm" action="{{ url('/login') }}" method="post">@csrf
                    <div class="control-group">
                        <label class="control-label" for="email">Email</label>
                        <div class="controls">
                            <input class="span3" type="email" id="email" name="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="password">Password</label>
                        <div class="controls">
                            <input type="password" class="span3" id="password" name ="password"placeholder="Password">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn">Sign in</button> <a
                                href="forgetpass.html">Forget password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection