@extends('layouts.app')
@section('content')
    <!-- Simple login form -->
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <div class="panel panel-body login-form">

            <div class="text-center">
                <div><img src="{{ asset('assets/images/logo.png') }}" alt=""></div>
                <h5 class="content-group mt-2">Register to your account</h5>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="form-control required" placeholder="Enter Full Name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <div class="form-control-feedback">
                    <i class="icon-envelop text-muted"></i>
                </div>
                <input type="text" id="email" name="email" value="{{ old('email') }}"
                    class="form-control required" placeholder="Enter Email">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
                <input type="password" id="password" name="password" class="form-control required"
                    placeholder="Enter Password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
                <input type="password" id="password" name="password_confirmation" class="form-control required"
                    placeholder="Enter confirm Password">
            </div>

            <div class="form-group">
                <button type="submit" class="btn bg-pink-400 btn-block">{{ __('Register') }}<i
                        class="icon-circle-right2 position-right"></i></button>
            </div>
            <div class="text-center">
                <p>Already have an account? <a href="{{ route('login') }}" class="text-primary">Sign In</a></p>
            </div>
        </div>
    </form>
    <!-- /simple login form -->
@endsection
