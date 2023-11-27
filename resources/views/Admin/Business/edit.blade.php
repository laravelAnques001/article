@extends('Admin.layouts.common')
@section('title')
    {{ config('app.name') }} | Business Update
@endsection
@section('content')
    @php
        $start_time = date('H:i', strtotime($business->start_time));
        $end_time = date('H:i', strtotime($business->end_time));
    @endphp
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('business.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Business Edit</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Business Edit</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <!-- Horizontal form options -->
            <div class="row">
                <div class="col-md-12">

                    <!-- Business Information-->
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Business Information</h5>
                            </div>

                            <form action="{{ route('business.update', base64_encode($business->id)) }}" method="POST"
                                enctype="multipart/form-data" id="businessForm">
                                @csrf
                                @method('PUT')
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="business_name">Business Name:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="business_name"
                                                id="business_name" placeholder="Enter Business Name"
                                                value="{{ old('business_name', $business->business_name) }}">
                                            @error('business_name')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="business_number">Business Number:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="business_number"
                                                id="business_number" placeholder="Enter Business Number"
                                                value="{{ old('business_number', $business->user->mobile_number) }}" disable readonly>
                                            @error('business_number')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="business_email">Business Email:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="business_email"
                                                id="business_email" placeholder="Enter Business Email"
                                                value="{{ old('business_email', $business->user->email) }}" disable readonly>
                                            @error('business_email')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="gst_number">GST Number:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="gst_number" id="gst_number"
                                                placeholder="Enter GST Number"
                                                value="{{ old('gst_number', $business->gst_number) }}">
                                            <span class="text-brown-300">Exmple:22AAAAA0000A1Z5</span>
                                            @error('gst_number')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="service_id">Select Services:</label>
                                        <div class="col-lg-9">
                                            <select class="select js-example-placeholder-multiple border-2 form-control"
                                                name="service_id[]" id="service_id" multiple>
                                                {{--  <option value="">Select Service</option>  --}}
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}"
                                                        {{ is_array($business->service->pluck('id')->toArray()) && in_array($service->id, $business->service->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                        {{ $service->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('service_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="aminity_id">Select Aminities:</label>
                                        <div class="col-lg-9">
                                            <select class="select js-example-placeholder-multiple border-2 form-control"
                                                name="aminity_id[]" id="aminity_id" multiple>
                                                {{--  <option>Select Service</option>  --}}
                                                @foreach ($aminities as $aminity)
                                                    <option value="{{ $aminity->id }}"
                                                        {{ is_array($business->aminity->pluck('id')->toArray()) && in_array($aminity->id, $business->aminity->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                        {{ $aminity->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('aminity_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="year">Year:</label>
                                        <div class="col-lg-9">
                                            <input type="number" class="form-control" name="year" id="year"
                                                placeholder="Enter Business Start Year"
                                                value="{{ old('year', $business->year) }}" pattern="[0-9]{4}"
                                                min="1" max="9999">
                                            @error('year')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="start_time">Start Time:</label>
                                        <div class="col-lg-9">
                                            <input type="time" class="form-control" name="start_time" id="start_time"
                                                placeholder="Enter Business Time"
                                                value="{{ old('start_time', $start_time) }}">
                                            @error('start_time')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="end_time">End Time:</label>
                                        <div class="col-lg-9">
                                            <input type="time" class="form-control" name="end_time" id="end_time"
                                                placeholder="Enter Business Time" value="{{ old('end_time', $end_time) }}">
                                            @error('end_time')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{--  <div class="form-group">
                                        <label class="col-lg-3 control-label" for="amenities">Amenities:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="amenities" id="amenities"
                                                placeholder="Enter  Amenities"
                                                value="{{ old('amenities', $business->amenities) }}">
                                            @error('amenities')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>  --}}

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="website">Website:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="website" id="website"
                                                placeholder="Enter  Website"
                                                value="{{ old('website', $business->website) }}">
                                            @error('website')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="people_search">People Search:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="people_search"
                                                id="people_search" placeholder="Enter People Search"
                                                value="{{ old('people_search', $business->people_search) }}">
                                            @error('people_search')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="images">Images:</label>
                                        <div class="col-lg-9">
                                            <input type="file" class="file-styled" name="images[]" id="images"
                                                multiple value="{{ old('images') }}" accept="image/*">
                                            @foreach ($images as $image)
                                                <img src="{{ $image }}" alt="Business Media" width="100"
                                                    height="100" class="ml-5">
                                            @endforeach
                                            @error('images')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="description">Description:</label>
                                        <div class="col-lg-9">
                                            <textarea rows="2" cols="5" class="form-control" name="description" id="description"
                                                value="{{ old('description') }}" placeholder="Enter Business Description">{{ old('description', $business->description) }}</textarea>
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
                    <!-- /Business Information -->

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
            $('#businessForm').validate({
                errorClass: 'error m-error',
                errorElement: 'small',
                rules: {
                    business_name: {
                        required: true,
                    },
                    gst_number: {
                        required: true,
                    },
                    people_search: {
                        required: true,
                    },
                },
                messages: {
                    business_name: {
                        required: 'Please enter business name.',
                    },
                    gst_number: {
                        required: 'Please enter GST number.',
                    },
                    people_search: {
                        required: 'Please enter people search.',
                    },
                }
            });

            $('#businessForm').submit(function() {
                if ($('#businessForm').valid()) {
                    $('#businessForm').find('button[type=submit]').prop('disabled', true);
                }
            });
        });
    </script>
@endpush
