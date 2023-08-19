@extends('Admin.layouts.common')
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('polls.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Polls Show</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Polls Show</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <!-- Horizontal form options -->
            <div class="row">
                <div class="col-md-12">

                    <!-- Polls Information-->
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Polls Information</h5>
                            </div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Polls Title:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $polls->title }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Polls Link:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $polls->link }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Polls Description:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $polls->description }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Polls Image:</label>
                                    <div class="col-lg-9">
                                        <img src="{{ $polls->image_url }}" alt="Polls Image" width="100" height="100">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /Polls Information -->

                </div>
            </div>
            <!-- /vertical form options -->

        </div>
        <!-- /content area -->
    </div>
@endsection
