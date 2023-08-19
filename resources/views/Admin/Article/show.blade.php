@extends('Admin.layouts.common')
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('article.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Article Show</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Article Show</li>
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
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Select Category:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $article->category->name ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Article Title:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $article->title }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Article Link:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $article->link }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Article Tags:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $article->tags }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Article Description:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $article->description }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Article Media Type:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">
                                            {{ ($article->image_type == 0 ? 'Image' : $article->image_type == 1) ? 'Video' : '' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Article Media:</label>
                                    <div class="col-lg-9">
                                        @if ($article->image_type == 0)
                                            <img src="{{ $article->media_url }}" alt="Article Media"
                                                width="100" height="100">
                                        @elseif ($article->image_type == 1)
                                            <video width="150" height="150" controls>
                                                <source src="{{ $article->media_url }}" type="">
                                            </video>
                                        @endif
                                    </div>
                                </div>

                            </div>
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
