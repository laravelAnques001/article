@extends('Admin.layouts.common')
@section('title')
    {{ env('APP_NAME') }} | User Create
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <a href="{{ route('users.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                    <span class="text-semibold">User Create</span>
                </h4>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>User Create</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <!-- Horizontal form options -->
        <div class="row">
            <div class="col-md-12">

                <!-- User Information-->
                <div class="form-horizontal">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title">User Information</h5>
                        </div>
                        <div class="panel-body">
                            {{--  <form wire:submit.prevent="save">  --}}
                            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"
                                id="userForm">
                                @csrf
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="name">User Name:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Enter User Name" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>   

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="email">User Email:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="email" id="email"
                                            placeholder="Enter User Email" value="{{ old('name') }}">
                                        @error('email')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>                                

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="dial_code">User Mobile Number:</label>
                                    <div class="col-lg-1">
                                        <input type="text" class="form-control" name="dial_code" id="dial_code"
                                            placeholder="91" value="{{ old('dial_code',91) }}">
                                        @error('dial_code')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="mobile_number" id="mobile_number"
                                            placeholder="Enter User Mobile Number" value="{{ old('mobile_number') }}">
                                        @error('mobile_number')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="device_token">User Device Token:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="device_token" id="device_token"
                                            value="{{ old('device_token') }}" placeholder="Enter User Device Token">
                                        @error('device_token')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="image">User Image:</label>
                                    <div class="col-lg-9">
                                        <input type="file" class="file-styled" name="image" id="image"
                                            value="{{ old('image') }}">
                                        <span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                                        @error('image')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>                            

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit form <i
                                            class="icon-arrow-right14 position-right"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /User Information -->

            </div>
        </div>
        <!-- /vertical form options -->

    </div>
    <!-- /content area -->
@endsection
@push('head_scripts')
    <script>
        $(document).ready(function(){
            $('#userForm').validate({
                errorClass: 'error m-error',
                errorElement: 'small',
                rules: {
                    name: {
                        required: true,                        
                    },
                    email: {
                        required: true,
                        email: true,
                    },                  
                    dial_code: {
                        required: true,
                        number: true,
                    },
                    mobile_number: {
                        required: true,
                        number: true,
                    },                    
                },
                messages: {
                    name: {
                        required: 'Please enter user name.',
                    },
                    email: {
                        required: 'Please enter user email.',
                        email: 'Enter valid email address.',
                    },                              
                    dial_code: {
                        required: 'Please enter user dial code.',
                        number: 'Enter valid number.',
                    },
                    mobile_number: {
                        required: 'Please enter user mobile no.',
                        number: 'Please enter number.',
                    },                   
                }
            });

            $('#userForm').submit(function() {
                if ($('#userForm').valid()) {
                    $('#userForm').find('button[type=submit]').prop('disabled', true);
                }
            });
        });
    </script>
@endpush
