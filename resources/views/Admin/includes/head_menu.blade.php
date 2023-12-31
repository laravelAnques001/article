<!-- Main navbar -->
@php
    $notification = \App\Models\AdminNotification::latest()
        ->take(10)
        ->get();
@endphp
<div class="navbar navbar-default header-highlight">
    <div class="navbar-header navbar-header-color">
        <a class="navbar-brand navbar-brand-header" href="#">
            {{--  <img src="{{ asset('assets/images/readwave_banner.png') }}" alt="">  --}}
            <img src="{{ asset('assets/images/business_white_banner.png') }}">
        </a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav nav-hide">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a>
            </li>
        </ul>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-bell2"></i>
                        <span class="visible-xs-inline-block position-right">Activity</span>
                        <span class="status-mark border-pink-300"></span>
                    </a>

                    <div class="dropdown-menu dropdown-content">
                        <ul class="media-list dropdown-content-body width-350">
                            @foreach ($notification as $notify)
                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-success-400 btn-rounded btn-icon btn-xs"><i
                                                class="icon-bubble8"></i></a>
                                    </div>
                                    <div class="media-body">
                                        <b>{{ $notify->title }}</b><br>
                                        {{ $notify->description }}
                                        {{--  <div class="media-annotation">4 minutes ago</div>  --}}
                                        <div class="media-annotation">{{ $notify->ago}}</div>
                                    </div>
                                </li>
                            @endforeach                         
                        </ul>
                    </div>
                </li>

                <li class="dropdown user user-menu nav-hide">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">My Account</span>
                    </a>
                    <ul class="dropdown-menu">

                        <li>
                            <a href="{{ route('profile') }}"><i class="icon-user-plus"></i> <span>My Profile</span></a>
                        </li>
                        <li>
                            <a href="{{ route('resetpassword') }}"><i class="icon-lock2"></i> <span>Change
                                    Password</span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="document.getElementById('logoutuser').submit();"><i
                                    class="icon-switch2"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                    <form action="{{ route('logout') }}" method="post" enctype="multipart/form-data" id="logoutuser">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /main navbar -->
