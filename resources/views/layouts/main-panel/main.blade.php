<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar {{ config('inspinia.navbar-skin', 'navbar-static-top') }}" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                @yield('top-search')
            </div>
            <ul class="nav navbar-top-links navbar-right">
                @yield('top-links')
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i>{!! trans('inspinia::main.logout') !!}
                    </a>
                </li>
            </ul>

        </nav>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>@yield('content-title', 'Title')</h2>
            @yield('breadcrumbs')
        </div>
        <div class="col-lg-4">
            <div class="title-action">
                @yield('header-actions')
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        @yield('content')
    </div>
    @include('inspinia::layouts.main-panel.footer.main')
</div>
