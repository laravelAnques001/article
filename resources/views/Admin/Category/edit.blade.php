@extends('Admin.layouts.common')
@section('title')
    {{ env('APP_NAME') }} | Category Update
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <a href="{{ route('category.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                    <span class="text-semibold">Category Edit</span>
                </h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>Category Edit</li>
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
                            {{--  <form wire:submit.prevent="update">  --}}
                            <form action="{{ route('category.update', base64_encode($category->id)) }}" method="POST"
                                enctype="multipart/form-data" id="categoryform">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="namre">Category Name:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Enter Category Name" value="{{ old('name', $category->name) }}">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{--  <div class="form-group">
                                    <label class="col-lg-3 control-label" for="parent_id">Select Patent Category:</label>
                                    <div class="col-lg-9">
                                        <select class="select" name="parent_id" id="parent_id">
                                            <option value="">Select Parent Category</option>
                                            @foreach ($categoryList as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ $category->parent_id == $data->id ? 'selected' : null }}>
                                                    {{ $data->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>  --}}

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="image">Category Image:</label>
                                    <div class="col-lg-9">
                                        <input type="file" class="file-styled" name="image" id="image">
                                        <span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                                        <img src="{{ $category->image_url }}" alt="category image" width="100"
                                            height="100">
                                        @error('image')
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
                <!-- /Category Information -->

            </div>
        </div>
        <!-- /vertical form options -->

    </div>
    <!-- /content area -->
@endsection
@push('head_scripts')
    <script>
        $(document).ready(function(){
            $('#categoryform').validate({
                errorClass: 'error m-error',
                errorElement: 'small',
                rules: {
                    name: {
                        required: true,
                    }
                }
            });

            $('#categoryform').submit(function() {
                if ($('#categoryform').valid()) {
                    $('#categoryform').find('button[type=submit]').prop('disabled', true);
                }
            });
        });
    </script>
@endpush
