@extends('Admin.layouts.common')
@section('title')
    {{ 'Profile - ' }}{{ config('constants.PROJECT_TITLE') }}
@endsection

@section('content')
    <script>
        $(document).ready(function() {
            $('#formadd').validate({ // initialize the plugin
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    mobile_number: {
                        required: true,
                    },
                    image: {
                        required: false,
                    },
                },
                messages: {
                    name: {
                        required: "Name field is required.",
                    },
                    mobile_number: {
                        required: "Mobile Number field is required.",
                    },
                    email: {
                        required: "Email field is required.",
                    }

                },
            });
        });

        $('#formadd').submit(function() {
            if ($(this).valid()) {

                $(this).find('button[type=submit]').prop('disabled', true);
            }
        });
    </script>
    <script></script>
    </script>
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><a href="{{ route('dashboard') }}"><i class="icon-arrow-left52 position-left"></i></a> <span
                        class="text-semibold">User Profile</span></h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>User Profile</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('profile.update') }}" id="formadd" enctype="multipart/form-data">
                    @csrf
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title">Profile Update</h5>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Enter Name" value="{{ old('name', $users->name) }}">
                                    @error('email')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        value="{{ old('email', $users->email) }}">
                                    @error('email')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mobile_number">Mobile Number</label>
                                    <input type="text" name="mobile_number" id="mobile_number" class="form-control"
                                        placeholder="Enter Mobile Number"
                                        value="{{ old('mobile_number', $users->mobile_number) }}">
                                    @error('mobile_number')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="image">Profile Image: </label>
                                    <input type="file" name="image" class="file-styled" accept="image/*">
                                    @error('image')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                    @if ($users->image_url)
                                        <img src="{{ $users->image_url }}" alt="User Profile" width="100"
                                            height="100">
                                    @endif
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-labeled-right1 bg-blue heading-btn">Update
                                    Profile</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
