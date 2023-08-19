@extends('Admin.layouts.common')
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('polls.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Polls Create</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Polls Create</li>
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
                            <form action="{{ route('polls.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="title">Polls Title:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Enter Polls title" value="{{ old('title') }}">
                                            @error('title')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="link">Polls Link:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="link" id="link"
                                                placeholder="Enter Polls Link" value="{{ old('link') }}">
                                            @error('link')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="image">Polls Image:</label>
                                        <div class="col-lg-9">
                                            <input type="file" class="file-styled" name="image" id="image" accept="image/*"
                                                value="{{ old('image') }}">
                                            @error('image')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="description">Polls Description:</label>
                                        <div class="col-lg-9">
                                            <textarea rows="2" cols="5" class="form-control" name="description" id="description"
                                                value="{{ old('description') }}" placeholder="Enter Polls Description"></textarea>
                                            @error('description')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Submit Form <i
                                                class="icon-arrow-right14 position-right"></i></button>
                                    </div>
                                </div>
                            </form>
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
