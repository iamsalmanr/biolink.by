<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{___('Installation')}} - {{env('APP_NAME')}}</title>

    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('global/fonts/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('install-assets/style.css') }}">
</head>
<body class="d-flex flex-column">
<div class="d-flex flex-column flex-fill">
    <div class="bg-base-1 flex-fill">
        <div class="container">
            <div class="row h-100 justify-content-center align-items-center py-5">
                <div class="col-lg-6">
                    @include('install.menu')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
