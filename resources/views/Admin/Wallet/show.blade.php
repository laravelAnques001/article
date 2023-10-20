@extends('Admin.layouts.common')
@section('title')
    {{ config('app.name') }} | Wallet Show
@endsection
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('wallet.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Wallet Show</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>
                        Wallet Show
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

                    <!-- Wallet Information-->
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Wallet Information</h5>
                            </div>
                            <div class="panel-body">

                                {{--  <div class="form-group">
                                    <label class="col-lg-3 control-label">Date:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $wallet->date }}</p>
                                    </div>
                                </div>  --}}

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">User Name:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $wallet->user->name }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Status:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $wallet->status }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Transaction Id:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $wallet->transaction_id }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Amount:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $wallet->amount }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Payment Response:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $wallet->payment_response }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /Wallet Information -->

                </div>
            </div>
            <!-- /vertical form options -->

        </div>
        <!-- /content area -->
    </div>
@endsection
