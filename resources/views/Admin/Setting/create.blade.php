@extends('Admin.layouts.common')
@section('title')
    {{ config('app.name') }} | Setting Create
@endsection
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('setting.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Setting Create</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Setting Create</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <!-- Horizontal form options -->
            <div class="row">
                <div class="col-md-12">

                    <!-- Setting Information-->
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Setting Information</h5>
                            </div>
                            {{--  <form wire:submit.prevent="save">  --}}
                            <form action="{{ route('setting.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="key">Key:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="key" id="key"
                                                placeholder="Enter Key" value="{{ old('key') }}">
                                            @error('key')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="value">Value:</label>
                                        <div class="col-lg-9">
                                            {{--  <textarea class="ckeditor form-control" name="value" placeholder="Enter Value"></textarea>  --}}
                                            <input type="text" class="form-control" name="value" id="value"
                                                placeholder="Enter value" value="{{ old('value') }}">
                                            @error('value')
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
                    <!-- /Setting Information -->

                </div>
            </div>
            <!-- /vertical form options -->

        </div>
        <!-- /content area -->
    </div>
@endsection
{{--  @push('custom-scripts')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
@endpush  --}}
