@extends('Admin.layouts.common')
@section('title')
    {{ config('app.name')}} | Aminity show
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <a href="{{ route('aminity.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                    <span class="text-semibold">Aminity Show</span>
                </h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>Aminity Show</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <!-- Horizontal form options -->
        <div class="row">
            <div class="col-md-12">

                <!-- Aminity Information-->
                <div class="form-horizontal">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title">Aminity Information</h5>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Aminity Name:</label>
                                <div class="col-lg-9">
                                    <p class="col-lg-3">{{ $aminity->name ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Aminity Information -->

            </div>
        </div>
        <!-- /vertical form options -->

    </div>
    <!-- /content area -->
@endsection
