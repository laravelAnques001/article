@extends('Admin.layouts.common')
@section('title')
    {{ env('APP_NAME') }} | Services Create
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <a href="{{ route('services.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                    <span class="text-semibold">Services Create</span>
                </h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>Services Create</li>
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
                            {{--  <form wire:submit.prevent="save">  --}}
                            <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data"
                                id="servicesform">
                                @csrf
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="title">Title:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter Title" value="{{ old('title') }}">
                                        @error('title')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="company_name">Company Name:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="company_name" id="company_name"
                                            placeholder="Enter Company Name" value="{{ old('company_name') }}">
                                        @error('company_name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="location">Location:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="location" id="location"
                                            placeholder="Enter location" value="{{ old('location') }}">
                                        @error('location')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="short_description">Short Description:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="short_description"
                                            id="short_description" placeholder="Enter short description"
                                            value="{{ old('short_description') }}">
                                        @error('short_description')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="image">Image:</label>
                                    <div class="col-lg-9">
                                        <input type="file" class="file-styled" name="image" id="image"
                                            value="{{ old('image') }}">
                                        <span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                                        @error('image')
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
                <!-- /Services Information -->

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
                    title: {
                        required: true,
                    },
                    company_name: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                    image: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: 'Please service title required.',
                    },
                    company_name: {
                        required: 'Please service company name required.',
                    },
                    location: {
                        required: 'Please service location required.',
                    },
                    image: {
                        required: 'Please service image required.',
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
