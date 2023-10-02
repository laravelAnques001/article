@extends('Admin.layouts.common')
@section('title')
    {{ env('APP_NAME') }} | Wallet Update
@endsection
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('wallet.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Wallet Edit</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Wallet Edit</li>
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

                            <form action="{{ route('wallet.update', base64_encode($wallet->id)) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="panel-body">

                                    {{--  <div class="form-group">
                                        <label class="col-lg-3 control-label" for="date">Date:</label>
                                        <div class="col-lg-9">
                                            <input type="datetime-local" class="form-control" name="date" id="date"
                                                placeholder="Enter Wallet Date" value="{{ old('date', $wallet->date) }}">
                                            @error('date')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>  --}}

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="user_id">Select User:</label>
                                        <div class="col-lg-9">
                                            <select class="select" name="user_id" id="user_id">
                                                <option value="">Select User</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('user_id', $wallet->user_id) == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="status">Select Status:</label>
                                        <div class="col-lg-9">
                                            <select class="select" name="status" id="status">
                                                <option value="">Select Status</option>
                                                <option value="SUCCESS" {{ old('status',$wallet->status)=='SUCCESS'?'selected':''}}>SUCCESS</option>
                                                <option value="FAILURE" {{ old('status',$wallet->status)=='FAILURE'?'selected':''}}>FAILURE</option>
                                                <option value="CANCEL" {{ old('status',$wallet->status)=='CANCEL'?'selected':''}}>CANCEL</option>
                                            </select>
                                            @error('status')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="transaction_id">Transaction Id:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="transaction_id"
                                                id="transaction_id" placeholder="Enter Wallet Transaction Id"
                                                value="{{ old('transaction_id', $wallet->transaction_id) }}">
                                            @error('transaction_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="amount">Amount:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="amount" id="amount"
                                                placeholder="Enter Wallet Amount"
                                                value="{{ old('amount', $wallet->amount) }}">
                                            @error('amount')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="payment_response">Payment
                                            Response:</label>
                                        <div class="col-lg-9">
                                            <textarea rows="2" cols="5" class="form-control" name="payment_response" id="payment_response"
                                                value="{{ old('payment_response') }}" placeholder="Enter Wallet Payment Response">{{ $wallet->payment_response }}</textarea>
                                                <span class='text-info'>(Json encode format data added(Payment Response))</span>
                                            @error('payment_response')
                                                <span class="error">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Submit form <i
                                                class="icon-arrow-right14 position-right"></i></button>
                                    </div>
                                </div>
                            </form>
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
