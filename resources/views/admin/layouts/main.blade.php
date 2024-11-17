<!DOCTYPE html>
<html lang="{{ get_lang() }}" class="light-style layout-menu-fixed layout-compact">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ page_title($__env) }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/brand/'.$settings->media->favicon) }}">
    @include('admin.includes.styles')
</head>
<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Page Sidebar Start-->
    @include('admin.includes.sidebar')

    <!-- Layout container -->
        <div class="layout-page">
            <!-- Page Header Start-->
        @include('admin.includes.header')
        <!-- Content wrapper -->
            <div class="content-wrapper">
                <div class="container-fluid py-3">
                    <div class="row align-items-center">
                        <div class="col mb-4">
                            <div class="page-header">
                                <div class="main-header">
                                    <h2 class="mb-2">@yield('title')</h2>
                                    <h6 class="mb-0">{{___('admin panel')}}</h6>
                                </div>
                            </div>
                        </div>
                        @hasSection('header_buttons')
                            <div class="col-auto mb-4">
                                @yield('header_buttons')
                            </div>
                        @endif
                    </div>
                </div>
                <div class="container-fluid flex-grow-1">
                    @yield('content')
                </div>

                <!-- footer start-->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 footer-copyright">
                                <p class="mb-0">{{___('Copyright')}} © {{date("Y")}} <a href="https://bylancer.com" target="_blank">Bylancer</a>. {{___('All rights reserved.')}} </p>
                            </div>
                            <div class="col-md-6">
                                <p class="float-end mb-0">{{___('Hand-crafted & made with')}} <i class="icon-feather-heart"></i></p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>

@include('admin.includes.scripts')
</body>
</html>
