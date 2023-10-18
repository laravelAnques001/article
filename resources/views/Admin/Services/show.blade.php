@extends('Admin.layouts.common')
@section('title')
    {{ env('APP_NAME') }} | Services show
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <a href="{{ route('services.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                    <span class="text-semibold">Services Show</span>
                </h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>Services Show</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <!-- Horizontal form options -->
        <div class="row">
            <div class="col-md-12">

                <!-- Services Information-->
                <div class="form-horizontal">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title">Services Information</h5>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Title:</label>
                                <div class="col-lg-9">
                                    <p class="col-lg-3">{{ $services->title ?? '' }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Company Name:</label>
                                <div class="col-lg-9">
                                    <p class="col-lg-3">{{ $services->company_name ?? '' }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Company Location:</label>
                                <div class="col-lg-9">
                                    <p class="col-lg-3">{{ $services->location ?? '' }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Short Description:</label>
                                <div class="col-lg-9">
                                    <p class="col-lg-3">{{ $services->short_description ?? '' }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Image:</label>
                                <div class="col-lg-9">
                                    <div class="col-lg-9">
                                        <img src="{{ $services->image_url ?? '' }}" alt="Services Image" width="100"
                                            height="100">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Description:</label>
                                <div class="col-lg-9">
                                    <textarea class="ckeditor form-control" name="description">{{ $services->description }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Services Information -->

            </div>
        </div>
        <!-- /vertical form options -->

    </div>
    <!-- /content area -->
@endsection
