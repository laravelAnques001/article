@extends('layouts.app')
@section('custom-script-head')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#formadd').validate({ // initialize the plugin
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    },
                },
                messages: {
                    email: {
                        required: "Email fields is required.",
                        email: "Please enter a valid email address",
                    },
                    password: {
                        required: "Password fields is required.",
                    },
                },
            });
        });
    </script>
@endsection
@section('content')
    <!-- Simple login form -->
    <form method="POST" action="{{ route('login.admin') }}" id="formadd">
        @csrf
        <div class="panel panel-body login-form">
            @if (session('error'))
                <div class="alert alert-danger no-border">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span
                            class="sr-only">Close</span></button>
                    <span class="text-semibold">{{ session('error') }}</span>.
                </div>
            @elseif(session('success'))
                <div class="alert alert-success no-border">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span
                            class="sr-only">Close</span></button>
                    <span class="text-semibold">{{ session('success') }}</span>
                </div>
            @endif
            <div class="text-center">
                <!--                                    <div class="icon-object border-slate-300 text-slate-300">
                                                <i class="icon-reading"></i>
                                            </div>-->
                <!--<h5> Bizzbrain Paymentgateway</h5>-->
                <div><img src="{{ asset('assets/images/logo.png') }}" style="width:60%; height: 30%;" alt=""></div>
                <h5 class="content-group">Login to your account <small class="display-block">Enter your
                        credentials below</small></h5>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
                <input type="text" id="email" name="email" :value="old('email')" class="form-control required"
                    placeholder="Enter Email">

            </div>

            <div class="form-group has-feedback has-feedback-left">
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
                <input type="password" id="password" name="password" class="form-control required"
                    placeholder="Enter Password">
            </div>

            <div class="form-group">
                <button type="submit" class="btn bg-pink-400 btn-block">{{ __('Log in') }}<i
                        class="icon-circle-right2 position-right"></i></button>
            </div>

            <div class="text-center">
                <a href="#">Forgot password</a>
            </div>
        </div>
    </form>
    <!-- /simple login form -->
@endsection
