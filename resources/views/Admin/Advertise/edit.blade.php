@extends('Admin.layouts.common')
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('advertise.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Advertise Edit</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Advertise Edit</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <!-- Horizontal form options -->
            <div class="row">
                <div class="col-md-12">

                    <!-- Advertise Information-->
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Advertise Information</h5>
                            </div>

                            <form action="{{ route('advertise.update', base64_encode($advertise->id)) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="article_id">Target:</label>
                                        <div class="col-lg-9">
                                            <select class="select" name="article_id" id="article_id">
                                                <option value="">Select Target</option>
                                                @foreach ($articles as $article)
                                                    <option value="{{ $article->id }}"
                                                        {{ old('article_id', $advertise->article_id) == $article->id ? 'selected' : '' }}>
                                                        {{ $article->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('article_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="target">Advertise Target:</label>
                                        <div class="col-lg-9">
                                            <select class="select" name="target" id="target">
                                                <option value="">Select Target</option>
                                                <option value="0" {{ $advertise->target == 0 ? 'selected' : '' }}>All
                                                </option>
                                                <option value="1" {{ $advertise->target == 1 ? 'selected' : '' }}>Own
                                                </option>
                                            </select>
                                            @error('target')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="latitude">Advertise Latitude:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="latitude" id="latitude"
                                                placeholder="Enter Article Latitude"
                                                value="{{ old('latitude', $advertise->latitude) }}">
                                            @error('latitude')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="longitude">Advertise Longitude:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="longitude" id="longitude"
                                                placeholder="Enter Article Longitude"
                                                value="{{ old('longitude', $advertise->longitude) }}">
                                            @error('longitude')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="redis">Redis:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="redis" id="redis"
                                                placeholder="Enter Advertise Redis"
                                                value="{{ old('redis', $advertise->redis) }}">
                                            @error('redis')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="budget">Advertise Budget:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="budget" id="budget"
                                                placeholder="Enter Article Budget"
                                                value="{{ old('budget', $advertise->budget) }}">
                                            @error('budget')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="start_date">Start Date:</label>
                                        <div class="col-lg-9">
                                            <input type="datetime-local" class="form-control" name="start_date"
                                                id="start_date" placeholder="Enter Article Start Date"
                                                value="{{ old('start_date', $advertise->start_date) }}">
                                            @error('start_date')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="end_date">End Date:</label>
                                        <div class="col-lg-9">
                                            <input type="datetime-local" class="form-control" name="end_date"
                                                id="end_date" placeholder="Enter Article End Date"
                                                value="{{ old('end_date', $advertise->end_date) }}">
                                            @error('end_date')
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
                    <!-- /Advertise Information -->

                </div>
            </div>
            <!-- /vertical form options -->

        </div>
        <!-- /content area -->
    </div>
@endsection