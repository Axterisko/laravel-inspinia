<div class="sidebar-collapse">
    <a class="close-canvas-menu"><i class="fa fa-times"></i></a>
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element">
                <img alt="image" class="rounded-circle"
                     src="@yield('user-avatar', 'http://www.gravatar.com/avatar/?d=mm')" style="max-width: 48px"/>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="block m-t-xs font-bold">@yield('user-name', 'Admin')</span>
                    <span class="text-muted text-xs block">@yield('user-text', 'Web Developer') <b
                            class="caret"></b></span>
                </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    @yield('user-menu')
                    <li>
                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href=""
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                </ul>
            </div>
            <div class="logo-element">
                {!! trans('inspinia::main.logo_small') !!}
            </div>
        </li>
        @section('sidebar-menu')
            <li class="active">
                <a href="/"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span></a>
            </li>
            <li>
                <a href="/"><i class="fa fa-sitemap"></i> <span class="nav-label">Menu Levels </span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="#">Third Level <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>

                        </ul>
                    </li>
                    <li><a href="#">Second Level Item</a></li>
                </ul>
            </li>
    @show
</div>
