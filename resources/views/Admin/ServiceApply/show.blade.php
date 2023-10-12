@extends('Admin.layouts.common')
@section('title')
    {{ config('app.name') }} | Digital Service Apply Show
@endsection
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('digitalServiceApply.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Digital Service Apply Show</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Digital Service Apply Show</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <!-- Horizontal form options -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Business Information-->
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Digital Service Apply Information</h5>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Service Title:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $serviceApply->service->title }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Name:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $serviceApply->name }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Email:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $serviceApply->email }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Mobile Number:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $serviceApply->mobile_number }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Message:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $serviceApply->message }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /Business Information -->

                </div>
            </div>
            <!-- /vertical form options -->

        </div>
        <!-- /content area -->
    </div>
@endsection
