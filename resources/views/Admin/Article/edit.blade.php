@extends('Admin.layouts.common')
@section('title')
    {{ config('app.name') }} | Article Update
@endsection
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('article.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Article Edit</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Article Edit</li>
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

                            {{--  <form wire:submit.prevent="update">  --}}
                            <form action="{{ route('article.update', base64_encode($article->id)) }}" method="POST"
                                enctype="multipart/form-data" id="articleForm">
                                @csrf
                                @method('PUT')
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="category_id">Select Category Of
                                            Article:</label>
                                        <div class="col-lg-9">
                                            <select class="select" name="category_id[]" id="category_id" multiple>
                                                <option value="">Select Category</option>
                                                @foreach ($categoryList as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ is_array($article->category->pluck('id')->toArray()) && in_array($category->id, $article->category->pluck('id')->toArray()) ? 'selected' : null }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('caregory_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="title">Article Title:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Enter Article title"
                                                value="{{ old('title', $article->title) }}">
                                            @error('title')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="link">Article Link:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="link" id="link"
                                                placeholder="Enter Article Link" value="{{ old('link', $article->link) }}">
                                            @error('link')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="tags">Article Tags:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="tags" id="tags"
                                                placeholder="Enter Article Tags" value="{{ old('tags', $article->tags) }}">
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
                                                <option value="0"
                                                    {{ old('image_type', $article->image_type) == 0 ? 'selected' : '' }}>
                                                    Image
                                                </option>
                                                <option value="1"
                                                    {{ old('image_type', $article->image_type) == 1 ? 'selected' : '' }}>
                                                    Video
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
                                                <option value="In-Review"
                                                    {{ old('status', $article->status) == 'In-Review' ? 'selected' : '' }}>
                                                    In-Review</option>
                                                <option value="Approved"
                                                    {{ old('status', $article->status) == 'Approved' ? 'selected' : '' }}>
                                                    Approved</option>
                                                <option value="Rejected"
                                                    {{ old('status', $article->status) == 'Rejected' ? 'selected' : '' }}>
                                                    Rejected</option>
                                            </select>
                                            @error('status')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="media">Article
                                            Media:</label>
                                        <div class="col-lg-9">
                                            <input type="file" class="file-styled" name="media" id="media"
                                                value="{{ old('media') }}">
                                            @error('media')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                            @if ($article->image_type == 0)
                                                <img src="{{ $article->media }}" alt="Article Media" width="100"
                                                    height="100">
                                            @elseif ($article->image_type == 1)
                                                <video width="150" height="150" controls>
                                                    <source src="{{ $article->thumbnail }}" type="">
                                                </video>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="description">Article
                                            Description:</label>
                                        <div class="col-lg-9">
                                            <textarea rows="2" cols="5" class="form-control" name="description" id="description"
                                                placeholder="Enter Article Description">{{ old('description', $article->description) }}</textarea>
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
@push('head_scripts')
    <script>
        $('.js-example-placeholder-multiple').select2({
            placeholder: "Select Category"
        });

        $(document).ready(function() {
            $('#articleForm').validate({
                errorClass: 'error m-error',
                errorElement: 'small',
                rules: {
                    'category_id[]': {
                        required: true,
                    },
                    title: {
                        required: true,
                    },
                    link: {
                        required: true,
                        url: true,
                    },
                    tags: {
                        required: true,
                    },
                    image_type: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                },
                messages:{
                    'category_id[]': {
                        required: 'Please select at least 1 category.',
                    },
                    title: {
                        required: 'Please enter article title.',
                    },
                    link: {
                        required: 'Please enter article link.',
                        url: 'Please valid article link.',
                    },
                    tags: {
                        required: 'Please enter article tags.',
                    },
                    image_type: {
                        required: 'Please enter article image type.',
                    },
                    description: {
                        required: 'Please enter article description.',
                    },
                }
            });

            $('#articleForm').submit(function() {
                if ($('#articleForm').valid()) {
                    $('#articleForm').find('button[type=submit]').prop('disabled', true);
                }
            });
        });
    </script>
@endpush
