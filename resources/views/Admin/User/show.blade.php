@extends('Admin.layouts.common')
@section('title')
    {{ config('app.name') }} | User Show
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <a href="{{ route('users.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                    <span class="text-semibold">User Show</span>
                </h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>User Show</li>
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
                            <div class="form-group">
                                <label class="col-lg-3 control-label">User Name:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="{{ $user->name }}" readOnly>
                                </div>
                            </div>     

                            <div class="form-group">
                                <label class="col-lg-3 control-label">User Email:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="{{ $user->email }}" readOnly>
                                </div>
                            </div>                          

                            <div class="form-group">
                                <label class="col-lg-3 control-label">User Mobile Number:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="{{ $user->dial_code.'  '.$user->mobile_number }}" readOnly>
                                </div>
                            </div>                          
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">User Device Token:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="{{ $user->device_token }}" readOnly>
                                </div>
                            </div>                          

                            <div class="form-group">
                                <label class="col-lg-3 control-label">User Image:</label>
                                <div class="col-lg-9">
                                    @if($user->image)
                                        <img src="{{ $user->image}}" alt="User Image" width="100" height="100">
                                    @endif
                                </div>
                            </div>
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
