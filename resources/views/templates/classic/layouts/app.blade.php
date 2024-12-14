<!DOCTYPE html>
<html lang="{{ get_lang() }}">
<head>
    @include($activeTheme.'layouts.includes.head')
    @include($activeTheme.'layouts.includes.styles')
    {!! head_code() !!}
</head>
<body>
<x-demo-frame />
<div class="navbar-area bg-light nav-light">
    <div class="mobile-responsive-nav">
        <div class="mobile-responsive-menu">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img class="main-logo" src="{{  asset('storage/brand/logo_light_main.svg') }}" alt="{{ @$settings->site_title }}" />
                    <img class="white-logo" src="{{  asset('storage/brand/logo_light_main.svg') }}" alt="{{ @$settings->site_title }}" />
                </a>
            </div>
            <div class="sidemenu-header">
                <div class="responsive-burger-menu icon-group -secondary">
                    <i class="fa-solid fa-bars-staggered"></i>
                </div>
            </div>
        </div>
    </div>
    @include($activeTheme.'layouts.includes.nav-dashboard')
</div>

<div class="dashboard-container mt-50 pb-100 sm-pb-50 sm-pb-80">

    @include($activeTheme.'user.includes.dashboard-sidebar')

    <div class="main-dashboard-content d-flex flex-column mt-10">

        @yield('content')

        <!-- /# App Footer-->
        @include($activeTheme.'user.includes.footer')
        <!-- /# App Footer-->

    </div>
</div>

@include($activeTheme.'layouts.includes.addons')
@include($activeTheme.'layouts.includes.scripts')
</body>
</html>
