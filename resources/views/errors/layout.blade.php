<!DOCTYPE html>
<html lang="{{ get_lang() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ @$settings->general->site_name ?? 'Error' }} — @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset($settings->media->favicon ?? '') }}">
    <link rel="stylesheet" href="{{ asset(active_theme(true).'assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset(active_theme(true).'assets/css/style.css') }}">
</head>
<body>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1 class="display-1 fw-bold">@yield('code')</h1>
            <p class="fs-3"> @yield('message')</p>
            <p class="lead">
                @yield('description')
            </p>
            <a href="{{ url('/') }}" class="button -secondary">{{ ___('Back to home') }}</a>
        </div>
    </div>
</body>
</html>
