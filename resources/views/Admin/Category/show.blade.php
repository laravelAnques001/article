@extends('Admin.layouts.common')
@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <a href="{{ route('category.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                    <span class="text-semibold">Category Show</span>
                </h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>Category Show</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <!-- Horizontal form options -->
        <div class="row">
            <div class="col-md-12">

                <!-- Category Information-->
                <div class="form-horizontal">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title">Category Information</h5>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Category Name:</label>
                                <div class="col-lg-9">
                                    <p class="col-lg-3">{{ $category->name ?? '' }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Category Parent Id:</label>
                                <div class="col-lg-9">
                                    <div class="col-lg-9">
                                        <p class="col-lg-3">{{ $category->parent->name ?? '' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Category Image:</label>
                                <div class="col-lg-9">
                                    <div class="col-lg-9">
                                        <img src="{{ $category->image_url ?? '' }}" alt="Category Image" width="100"
                                            height="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Category Information -->

            </div>
        </div>
        <!-- /vertical form options -->

    </div>
    <!-- /content area -->
@endsection
