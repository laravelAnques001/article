@extends('Admin.layouts.common')
@section('title')
    {{ env('APP_NAME') }} | Setting Show
@endsection
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('setting.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Setting Show</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>
                        Setting Show
                    </li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <!-- Horizontal form options -->
            <div class="row">
                <div class="col-md-12">

                    <!-- Setting Information-->
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Setting Information</h5>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Key:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $setting->key }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Value:</label>
                                    <div class="col-lg-9">
                                        {!! html_entity_decode($setting->value) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Setting Information -->

                </div>
            </div>
            <!-- /vertical form options -->

        </div>
        <!-- /content area -->
    </div>
@endsection
