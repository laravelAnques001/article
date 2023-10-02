@extends('Admin.layouts.common')
@section('title')
    {{ env('APP_NAME') }} | Advertise Show
@endsection
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('advertise.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Advertise Show</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>
                        Advertise Show
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

                    <!-- Advertise Information-->
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Advertise Information</h5>
                            </div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Title:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $advertise->article->title }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Image:</label>
                                    <div class="col-lg-9">
                                        <img src="{{ $advertise->article->image_url }}" alt="Advertise Image" width="100"
                                            height="100">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Target:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">
                                            {{ ($advertise->target == 0 ? 'All' : $advertise->target == 1) ? 'Own' : '' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Budget:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">
                                            {{ $advertise->budget }}
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Start Date:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">
                                            {{ $advertise->start_date }}
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">End Date:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control"> {{ $advertise->end_date }} </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Status:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control"> {{ $advertise->status }} </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /Advertise Information -->
                </div>
            </div>
            <!-- /vertical form options -->

        </div>
        <!-- /content area -->
    </div>
@endsection
