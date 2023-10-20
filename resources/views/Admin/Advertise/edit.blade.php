@extends('Admin.layouts.common')
@section('title')
    {{ config('app.name') }} | Advertise Update
@endsection
@section('content')
    @php
        $start_date = date('Y-m-d\TH:i', strtotime($advertise->start_date));
        $end_date = date('Y-m-d\TH:i', strtotime($advertise->end_date));
    @endphp
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
                                        <label class="col-lg-3 control-label" for="article_id">Select Article:</label>
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
                                                value="{{ old('start_date', $start_date) }}">
                                            @error('start_date')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="end_date">End Date:</label>
                                        <div class="col-lg-9">
                                            <input type="datetime-local" class="form-control" name="end_date" id="end_date"
                                                placeholder="Enter Article End Date"
                                                value="{{ old('end_date', $end_date) }}">
                                            @error('end_date')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="status">Select Status:</label>
                                        <div class="col-lg-9">
                                            <select class="select" name="status" id="status">
                                                <option value="">Select Status</option>
                                                <option value="Pending"
                                                    {{ old('status', $advertise->status) == 'Pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="Published"
                                                    {{ old('status', $advertise->status) == 'Published' ? 'selected' : '' }}>
                                                    Published</option>
                                                <option value="Rejected"
                                                    {{ old('status', $advertise->status) == 'Rejected' ? 'selected' : '' }}>
                                                    Rejected</option>
                                            </select>
                                            @error('status')
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
