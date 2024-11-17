<style>
    :root{--color-primary: {{ $settings->colors->primary_color }} !important;
        @php
        $themecolor = $settings->colors->primary_color;
        list($r, $g, $b) = sscanf($themecolor, "#%02x%02x%02x");
        @endphp
        --theme-color-rgb: {{ "$r, $g, $b" }};
        --color-primary-l: rgba(var(--theme-color-rgb),0.08) !important;}
</style>
<!--Plugin CSS-->
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/plugin/owl-carousel/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/plugin/owl-carousel/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/plugin/magnific-poupup/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('global/fonts/css/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/plugin/simple-bar/simplebar.min.css') }}">
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/plugin/text-typer/typing-text.css') }}">
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/plugin/wow-animate/animate.css') }}">
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/plugin/snackbar/snackbar.min.css') }}">
<!--Theme CSS-->
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/css/responsive.css') }}">
<link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/css/dark.css') }}">

@if (!empty($settings->custom_css))
    <style>
        {{ trim($settings->custom_css) }}
    </style>
@endif
