@extends('Admin.layouts.common')
@section('title')
    {{ env('APP_NAME') }} | Subscription Plans show
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <a href="{{ route('subscriptionPlan.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                    <span class="text-semibold">Subscription Plans Show</span>
                </h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>Subscription Plans Show</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <!-- Horizontal form options -->
        <div class="row">
            <div class="col-md-12">

                <!-- Subscription Plans Information-->
                <div class="form-horizontal">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title">Subscription Plans Information</h5>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Name:</label>
                                <div class="col-lg-9">
                                    <p class="col-lg-3">{{ $subscriptionPlan->name ?? '' }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Time Period:</label>
                                <div class="col-lg-9">
                                    <p class="col-lg-3">{{ $subscriptionPlan->time_period ?? '' }}</p>
                                </div>
                            </div>

                            {{--  <div class="form-group">
                                <label class="col-lg-3 control-label">Start Date:</label>
                                <div class="col-lg-9">
                                    <p class="col-lg-3">{{ $subscriptionPlan->start_date ?? '' }}</p>
                                </div>
                            </div>  --}}

                            {{--  <div class="form-group">
                                <label class="col-lg-3 control-label">End Date:</label>
                                <div class="col-lg-9">
                                    <p class="col-lg-3">{{ $subscriptionPlan->end_date ?? '' }}</p>
                                </div>
                            </div>  --}}

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Price:</label>
                                <div class="col-lg-9">
                                    <p class="col-lg-3">{{ $subscriptionPlan->price ?? '' }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Description:</label>
                                <div class="col-lg-9">
                                    <textarea class="ckeditor form-control" name="description">{{ $subscriptionPlan->description }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Subscription Plans Information -->

            </div>
        </div>
        <!-- /vertical form options -->

    </div>
    <!-- /content area -->
@endsection
