@extends('Admin.layouts.common')
@section('title')
    {{ env('APP_NAME') }} | Subscription Plans Create
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <a href="{{ route('subscriptionPlan.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                    <span class="text-semibold">Subscription Plans Create</span>
                </h4>
            </div>
        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>Subscription Plans Create</li>
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
                            <form action="{{ route('subscriptionPlan.store') }}" method="POST"
                                enctype="multipart/form-data" id="servicesform">
                                @csrf
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="name">Name:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Enter Name" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="time_period">Select Time Period:</label>
                                    <div class="col-lg-9">
                                        <select class="select" name="time_period" id="time_period">
                                            <option disabled>Select Time Period</option>
                                            <option value="Monthly" selected> Monthly </option>
                                            <option value="Yearly" {{ old('time_period') == 'Yearly' ? 'selected' : '' }}>
                                                Yearly </option>
                                        </select>
                                        @error('time_period')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{--  <div class="form-group">
                                    <label class="col-lg-3 control-label" for="start_date">Start Date:</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" name="start_date" id="start_date"
                                            placeholder="Enter Start Date" value="{{ old('start_date') }}">
                                        @error('start_date')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>  --}}

                                {{--  <div class="form-group">
                                    <label class="col-lg-3 control-label" for="end_date">End Date:</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" name="end_date" id="end_date"
                                            placeholder="Enter End Date" value="{{ old('end_date') }}">
                                        @error('end_date')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>  --}}

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="price">Price:</label>
                                    <div class="col-lg-9">
                                        <input type="number" class="form-control" name="price" id="price"
                                            placeholder="Enter Price" value="{{ old('price') }}">
                                        @error('price')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="description">Description:</label>
                                    <div class="col-lg-9">
                                        <textarea class="ckeditor form-control" name="description" id="description" placeholder="Enter Description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit form <i
                                            class="icon-arrow-right14 position-right"></i></button>
                                </div>
                            </form>
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
@push('head_scripts')
    <script>
        $(document).ready(function() {
            $('#servicesform').validate({
                errorClass: 'error m-error',
                errorElement: 'small',
                rules: {
                    name: {
                        required: true,
                    },
                    time_period: {
                        required: true,
                    },
                    price: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please service name required.',
                    },
                    time_period: {
                        required: 'Please select at list 1.',
                    },
                    price: {
                        required: 'Please price required.',
                    },
                    description: {
                        required: 'Please description required.',
                    },
                }
            });

            $('#servicesform').submit(function() {
                if ($('#servicesform').valid()) {
                    $('#servicesform').find('button[type=submit]').prop('disabled', true);
                }
            });

            $('.ckeditor').ckeditor();
        });
    </script>
@endpush
