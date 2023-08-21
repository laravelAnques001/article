@extends('Admin.layouts.common')
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('article.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Article Create</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Article Create</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <!-- Horizontal form options -->
            <div class="row">
                <div class="col-md-12">

                    <!-- Article Information-->
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Article Information</h5>
                            </div>
                            {{--  <form wire:submit.prevent="save">  --}}
                            <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="category_id">Select Category Of
                                            Article:</label>
                                        <div class="col-lg-9">
                                            <select class="select" name="category_id" id="category_id">
                                                <option value="">Select Category</option>
                                                @foreach ($categoryList as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="title">Article Title:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Enter Article title" value="{{ old('title') }}">
                                            @error('title')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="link">Article Link:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="link" id="link"
                                                placeholder="Enter Article Link" value="{{ old('link') }}">
                                            @error('link')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="'tags">Article Tags:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="tags" id="tags"
                                                placeholder="Enter Article Tags" value="{{ old('tags') }}">
                                            @error('tags')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="image_type">Select Type Of
                                            Article:</label>
                                        <div class="col-lg-9">
                                            <select class="select" name="image_type" id="image_type">
                                                <option value="">Select Article Type</option>
                                                <option value="0" {{ old('link') == 0 ? 'selected' : '' }}>Image
                                                </option>
                                                <option value="1" {{ old('link') == 1 ? 'selected' : '' }}>Video
                                                </option>
                                            </select>
                                            @error('image_type')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="status">Select Article Status:</label>
                                        <div class="col-lg-9">
                                            <select class="select" name="status" id="status">
                                                <option value="">Select Article status</option>
                                                <option
                                                    value="In-Review"{{ old('status') == 'In-Review' ? 'selected' : '' }}>
                                                    In-Review</option>
                                                <option
                                                    value="Approved"{{ old('status') == 'Approved' ? 'selected' : '' }}>
                                                    Approved</option>
                                                <option
                                                    value="Rejected"{{ old('status') == 'Rejected' ? 'selected' : '' }}>
                                                    Rejected</option>
                                            </select>
                                            @error('status')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="media">Article Media:</label>
                                        <div class="col-lg-9">
                                            <input type="file" class="file-styled" name="media" id="media"
                                                value="{{ old('media') }}">
                                            @error('media')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="description">Article Description:</label>
                                        <div class="col-lg-9">
                                            <textarea rows="2" cols="5" class="form-control" name="description" id="description"
                                                value="{{ old('description') }}" placeholder="Enter Article Description"></textarea>
                                            @error('description')
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
                    <!-- /Article Information -->

                </div>
            </div>
            <!-- /vertical form options -->

        </div>
        <!-- /content area -->
    </div>
@endsection
