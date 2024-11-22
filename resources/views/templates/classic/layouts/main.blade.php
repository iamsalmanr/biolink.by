<!DOCTYPE html>
<html lang="{{ get_lang() }}">
<head>
    @include($activeTheme.'layouts.includes.head')
    @include($activeTheme.'layouts.includes.styles')
    {!! head_code() !!}
</head>
<body style="margin: 0; padding: 0; overflow-x: hidden;">

@php
    $navclass = $__env->yieldContent('navclass') ?: 'nav-light';
@endphp
<x-demo-frame />
<div class="navbar-area position-absolute {{ $navclass }}">
    @include($activeTheme.'layouts.includes.nav-main')
</div>
@yield('content')
@include($activeTheme.'layouts.includes.footer')
@include($activeTheme.'layouts.includes.addons')
@include($activeTheme.'layouts.includes.scripts')
</body>
</html>
