<!-- Main sidebar -->
<div class="sidebar sidebar-main">
    <div class="sidebar-content">
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">
                    <li class="{{ Route::currentRouteName() == 'catagory.*' ? 'active' : '' }}"><a
                            href="{{ route('dashboard') }}"><i class="icon-home4"></i> <span>DashBoard</span></a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'catagory.*' ? 'active' : '' }}"><a
                            href="{{ route('category.index') }}"><i class="fa fa-list-alt"></i> <span>Category</span></a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'article.*' ? 'active' : '' }}"><a
                            href="{{ route('article.index') }}"><i class="fa fa-newspaper-o"></i>
                            <span>Article</span></a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'advertise.*' ? 'active' : '' }}"><a
                            href="{{ route('advertise.index') }}"><i class="icon-users"></i>
                            <span>Advertise</span></a>
                    </li>
                    {{--  <li class="{{ Route::currentRouteName() == 'wallet.*' ? 'active' : '' }}"><a
                        href="{{ route('polls.index') }}"><i class="icon-people"></i></i></i>
                        <span>Polls</span></a>
                    </li>  --}}
                    <li class="{{ Route::currentRouteName() == 'wallet.*' ? 'active' : '' }}"><a
                            href="{{ route('wallet.index') }}"><i class="icon-book"></i>
                            <span>Wallet</span></a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'setting.*' ? 'active' : '' }}"><a
                            href="{{ route('setting.index') }}"><i class="fa fa-gear"></i>
                            <span>Setting</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
<!-- /main sidebar -->
