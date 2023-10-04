@extends('Admin.layouts.common')
@section('title')
    {{ config('app.name') }} | Business Show
@endsection
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('business.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Business Show</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Business Show</li>
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
                                <h5 class="panel-title">Business Information</h5>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="business_name">Business Name:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $business->business_name }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="gst_number">GST Number:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $business->gst_number }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="service_id">Select Services:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">
                                            {{ implode(', ', $business->service->pluck('title')->toArray()) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="year">Year:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $business->year }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="start_time">Start Time:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $business->start_time }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="end_time">End Time:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $business->end_time }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="amenities">Amenities:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $business->amenities }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="website">Website:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $business->website }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="people_search">People Search:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $business->people_search }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="images">Images:</label>
                                    <div class="col-lg-9">
                                        @foreach ($images as $image)
                                            <img src="{{ $image }}" alt="Article Media" width="100"
                                                height="100" class="ml-5">
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="description">Description:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $business->description }}</p>
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
