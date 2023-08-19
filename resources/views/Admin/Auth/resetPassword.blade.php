@extends('Admin.layouts.common')
@section('title')
    {{ 'Change Password - ' }}{{ config('constants.PROJECT_TITLE') }}
@endsection
<!-- Theme JS files -->

@section('content')
    <script>
        $(document).ready(function() {
            $('#formadd').validate({ // initialize the plugin
                rules: {
                    new_password: {
                        required: true,
                    },
                    old_password: {
                        required: true,
                    },
                    confirm_password: {
                        required: true,
                        equalTo: '[name="new_password"]'
                    }

                },
                messages: {
                    new_password: {
                        required: "New Password field is required.",
                    },
                    old_password: {
                        required: "Old Password field is required.",
                    },
                    confirm_password: {
                        required: "Confirm Password field is required.",
                        equalTo: "New Password And Confirm Password Must Be Same."
                    }

                },
            });
        });

        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

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
                        class="text-semibold">Change Password</span></h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>Change Password</li>
            </ul>
        </div>

    </div>
    <!-- /page header -->
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('resetpassword.store') }}" id="formadd">
                    @csrf
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title">Change Password</h5>

                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ $users->email }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>New Password</label>
                                    <input type="password" id="myInput" name="new_password" class="form-control"
                                        placeholder="Enter New Pasword">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Old Password</label>
                                    <input type="password" id="password-field" name="old_password" class="form-control"
                                        placeholder="Enter Old Password">
                                    @error('old_password')
                                        <span style="color:red"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Repeat Password</label>
                                    <input type="password" name="confirm_password" class="form-control"
                                        placeholder="Repeat New Password">
                                    @error('confirm_password')
                                        <span style="color:red"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="text-right">
                                <button type="submit" class="btn btn-labeled-right1 bg-blue heading-btn">Update
                                    Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
