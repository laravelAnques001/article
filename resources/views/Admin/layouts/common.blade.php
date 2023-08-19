<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="icon" type="image/png" sizes="16x16" href="#"/>-->
    <link href="{{ asset('assets/images/favicon.png') }}" sizes="128x128" rel="shortcut icon" />
    <title>@yield('title')</title>
    @include('Admin.includes.head_script')

</head>

<body>
    @include('Admin.includes.head_menu')

    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            @include('Admin.includes.sidebar')

            <!-- Main content -->
            <div class="content-wrapper">
                @yield('content')
                @include('Admin.includes.footer')
            </div>
            <!-- /main content -->
        </div>
        <!-- /page content -->

        <div class="modal fade" id="myModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
        <div id="product_detail_loader" class="preloader">
            <div class="inner-div-loader">
                <div class="lds-ripple">
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        @stack('custom-scripts')

    </div>
    <!-- /page container -->

    <script>
            $(document).on('click', '.ajaxviewmodel', function (event) {
                var tmp_html = '<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><p class="ajaxloader text-center"><i class="fa fa-refresh fa-spin fa-3x fa-fw  margin-top text-center"></i></p></div></div></div>';
                        event.preventDefault();
                var link = $(this).attr("href");

                $('#myModal').modal('show');
                $("#myModal").html(tmp_html);
                $.ajax({
                    url: link,
                    success: function (data) {

                        $(".ajaxloader").hide();
                        $("#myModal").html(data);
                    }
                });
            });
        </script>
    <script>
            @if (Session::has('success'))
                toastr.success("{{Session::get('success') }}", 'Success');
                @php
                Session::forget('success')
                @endphp
                @endif
                @if (Session::has('error'))
                toastr.error("{{ Session::get('error') }}", 'Error');
                @php
                Session::forget('error')
                @endphp
            @endif

        </script>

</body>

</html>
