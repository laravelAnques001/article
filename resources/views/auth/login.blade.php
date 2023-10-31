@extends('layouts.app')
@section('content')
    <form method="POST" action="{{ route('login') }}" id="formadd">
        @csrf
        <div class="panel panel-body login-form">

            <div class="text-center">
                <div><img src="{{ asset('assets/images/businessflipsbanner.jpeg') }}" alt="" width="250" height="150"></div>
                <h5 class="content-group">Login to your account <small class="display-block">Enter your
                        credentials below</small></h5>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
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

            <div class="form-group">
                <button type="submit" class="btn bg-pink-400 btn-block">{{ __('Log in') }}<i
                        class="icon-circle-right2 position-right"></i></button>
            </div>

            {{--  <div class="text-center">
                <a href="{{ route('register') }}">Create New Account</a>
            </div>  --}}
        </div>
    </form>
@endsection
