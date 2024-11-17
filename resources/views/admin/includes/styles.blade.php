<style>
    :root{--theme-color: {{ $settings->colors->primary_color }};
        @php
        $themecolor = $settings->colors->primary_color;
        list($r, $g, $b) = sscanf($themecolor, "#%02x%02x%02x");
        @endphp
        --theme-color-rgb: {{ "$r, $g, $b" }};}
</style>

<link rel="stylesheet" href="{{ asset('admin/assets/icons/css/feather-icon.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/slidePanel.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('global/fonts/css/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}">

@stack('styles_vendor')
{{--Can add any file--}}

<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/responsive.css') }}">
