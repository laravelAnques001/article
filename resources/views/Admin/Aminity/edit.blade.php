@extends('Admin.layouts.common')
@section('title')
    {{ config('app.name') }} | Aminity Update
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <a href="{{ route('aminity.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                    <span class="text-semibold">Aminity Edit</span>
                </h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>Aminity Edit</li>
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
                            {{--  <form wire:submit.prevent="update">  --}}
                            <form action="{{ route('aminity.update', base64_encode($aminity->id)) }}" method="POST"
                                enctype="multipart/form-data" id="aminityForm">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="namre">Aminity Name:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Enter Aminity Name" value="{{ old('name', $aminity->name) }}">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit Form <i
                                            class="icon-arrow-right14 position-right"></i></button>
                                </div>
                            </form>
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
@push('head_scripts')
    <script>
        $(document).ready(function() {
            $('#aminityForm').validate({
                errorClass: 'error m-error',
                errorElement: 'small',
                rules: {
                    name: {
                        required: true,
                    }
                }
            });

            $('#aminityForm').submit(function() {
                if ($('#aminityForm').valid()) {
                    $('#aminityForm').find('button[type=submit]').prop('disabled', true);
                }
            });
        });
    </script>
@endpush
