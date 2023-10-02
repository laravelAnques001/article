@extends('Admin.layouts.common')
@section('title')
    {{ env('APP_NAME') }} | Advertise List
@endsection
@push('custom-scripts')
    <!-- Theme JS files -->
    <script type="text/javascript" src="{{ asset('assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/switch.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/switchery.min.css') }}">
    <script src="{{ asset('js/switchery.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
    <!-- /theme JS files -->

    <script type="text/javascript">
        $(function() {
            $.extend($.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    width: '100px',
                    targets: [1]
                }],
                dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: {
                        'first': 'First',
                        'last': 'Last',
                        'next': '&rarr;',
                        'previous': '&larr;'
                    }
                },
                drawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    delete_recodes();
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass(
                        'dropup');
                }
            });
            $('.customer-table').DataTable({
                "processing": true,
                "serverSide": true,
                "select": true,
                "ajax": {
                    "url": "{{ route('admin.advertise.getData') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                        "data": "action",
                        "searchable": false,
                        "sortable": false
                    },
                    {
                        "data": "id"
                    },
                    {
                        "data": "article_id"
                    },
                    {
                        "data": "target"
                    },
                    {
                        "data": "budget"
                    },
                    {
                        "data": "start_date"
                    },
                    {
                        "data": "end_date"
                    },
                    {
                        "data": "impression"
                    },
                    {
                        "data": "click"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "ad_status"
                    },
                ]
            });

            function delete_recodes() {
                $('.delete_row').on('click', function() {
                    var url = $(this).attr("data-value");

                    swal({
                            title: "Are you sure?",
                            text: "You will not be able to recover this record!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#EF5350",
                            confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "No, cancel pls!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },

                        function(isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: url,
                                    type: "delete",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                    }
                                }).done(function(data) {
                                    swal({
                                        title: "Deleted!",
                                        text: "Advertise has been successfully deleted..",
                                        type: "success",
                                        showCancelButton: true,
                                        closeOnConfirm: false,
                                        confirmButtonColor: "#2196F3"
                                    });

                                    $('.customer-table').DataTable().row($(this).parents('tr'))
                                        .remove().draw();
                                });

                            } else {
                                swal({
                                    title: "Cancelled",
                                    text: "Your record is safe :)",
                                    confirmButtonColor: "#2196F3",
                                    type: "error"
                                });
                            }
                        });

                });
                var i = 0;
                if (Array.prototype.forEach) {

                    var elems = $('.switchery');
                    $.each(elems, function(key, value) {
                        var $size = "",
                            $color = "",
                            $sizeClass = "",
                            $colorCode = "";
                        $size = $(this).data('size');
                        var $sizes = {
                            'lg': "large",
                            'sm': "small",
                            'xs': "xsmall"
                        };
                        if ($(this).data('size') !== undefined) {
                            $sizeClass = "switchery switchery-" + $sizes[$size];
                        } else {
                            $sizeClass = "switchery";
                        }

                        $color = $(this).data('color');
                        var $colors = {
                            'primary': "#967ADC",
                            'success': "#37BC9B",
                            'danger': "#DA4453",
                            'warning': "#F6BB42",
                            'info': "#3BAFDA"
                        };
                        if ($color !== undefined) {
                            $colorCode = $colors[$color];
                        } else {
                            $colorCode = "#37BC9B";
                        }

                        var switchery = new Switchery($(this)[0], {
                            className: $sizeClass,
                            color: $colorCode
                        });
                    });
                } else {
                    var elems1 = document.querySelectorAll('.switchery');
                    for (i = 0; i < elems1.length; i++) {
                        var $size = elems1[i].data('size');
                        var $color = elems1[i].data('color');
                        var switchery = new Switchery(elems1[i], {
                            color: '#37BC9B'
                        });
                    }
                }

                $(".switch").change(function() {
                    var id = $(this).attr("data-value");
                    var state = 0;
                    if ($(this).prop("checked") == true) {
                        state = 0;
                    } else if ($(this).prop("checked") == false) {
                        state = 1;
                    }
                    var url = "{{ URL::to('advertise/ad_status') }}";
                    url = url + "/" + id + "/" + state;
                    $.ajax({
                        url: url,
                    }).done(function(data) {
                        if (data == 1) {
                            if (state == 0) {
                                toastr.success('Advertise has been On', 'Activated');
                            } else {
                                toastr.error('Advertise has been Off', 'Deactivated');
                            }
                        } else {
                            toastr.error('Something went wrong..', 'Error');
                        }

                    });
                });

                $(".switchStatus").change(function() {
                    var id = $(this).attr("data-value");
                    var state = 'Published';
                    if ($(this).prop("checked") == true) {
                        state = 'Published';
                    } else if ($(this).prop("checked") == false) {
                        state = 'Pending';
                    }
                    var url = "{{ URL::to('advertise/status') }}";
                    url = url + "/" + id + "/" + state;
                    $.ajax({
                        url: url,
                    }).done(function(data) {
                        if (data == 1) {
                            if (state == 'Published') {
                                toastr.success('Advertise has been Published', 'Activated');
                            } else {
                                toastr.error('Advertise has been pending', 'Deactivated');
                            }
                        } else {
                            toastr.error('Something went wrong..', 'Error');
                        }

                    });
                });
            }
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });
        });
    </script>
@endpush

@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><span class="text-semibold">Advertise list</span></h4>
                </div>
                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="{{ route('advertise.create') }}"
                            class="btn btn-labeled-right bg-blue heading-btn">Create Advertise
                        </a>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li>Advertise list</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">
            <!-- Page length options -->
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table datatable-basic customer-table table-framed">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>#</th>
                                    <th>Article Title</th>
                                    <th>Target</th>
                                    <th>Budget</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Impressions</th>
                                    <th>Clicks</th>
                                    <th>Status<br><small style="font-size: 70%;">(On=Published,Off=Pending)</small></th>
                                    <th>Ads Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Content area -->
    </div>
@endsection
