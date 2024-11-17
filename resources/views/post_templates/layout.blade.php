<!DOCTYPE html>
<html lang="{{ get_lang() }}">
<head>
    <meta charset="utf-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="index, follow">
    <meta name="title" content="{{ !empty($postOptions->seo_title) ? $postOptions->seo_title : $post->title }}">
    <meta name="description" content="{{ !empty($postOptions->seo_desc) ? $postOptions->seo_desc : $post->content }}" />
    <meta property="profile:username" content="{{ $post->slug }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/post/logo/'.$post->image) }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/post/logo/'.$post->image) }}">
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta property="og:title" content="{{ !empty($postOptions->seo_title) ? $postOptions->seo_title : $post->title }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:description" content="{{ !empty($postOptions->seo_desc) ? $postOptions->seo_desc : $post->content }}" />
    <meta property="og:image:secure_url" content="{{ asset('storage/post/logo/'.$post->image) }}" />
    <meta property="og:image" content="{{ asset('storage/post/logo/'.$post->image) }}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{ !empty($postOptions->seo_title) ? $postOptions->seo_title : $post->title }}" />
    <meta name="twitter:image" content="{{ asset('storage/post/logo/'.$post->image) }}" />
    <meta name="twitter:url" content="{{ url()->current() }}" />
    <link rel="preload" as="image" href="{{ asset('storage/post/logo/'.$post->image) }}" />
    <title>{{ !empty($postOptions->seo_title) ? $postOptions->seo_title : $post->title }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/post/logo/'.$post->image) }}">

    <!--Theme CSS-->
    <link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('global/fonts/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/css/helper.css') }}">
    <link rel="stylesheet" href="{{ asset($activeThemeAssets.'assets/plugin/wow-animate/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('post_templates/template-style.css') }}">

</head>
<body>
@yield('content')

<div class="animated fadeIn modal" id="share_social" tabindex="-1" aria-labelledby="shareModalLable" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title flex-grow-1 text-center" id="shareModalLable">{{ ___('Share Bio Link') }}</h5>
                <button type="button" class="icon-group -close"  data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-regular fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex gap-3 justify-content-center align-items-center flex-wrap my-24 sm-my-20">
                    <div class="card shadow-2 mb-0 p-0">
                        {!! $qr_image !!}
                    </div>
                    <div class="share-items-wrapper">
                        <a class="share-items" href="https://twitter.com/share?url={{ url($post->slug) }}&text={{ $post->title }}" target="_blank">
                            <div class="d-flex align-items-center">
                                <i class="fa-brands fa-twitter text-twitter font-20"></i>
                                <div class="ml-8">
                                    {{ ___('Share on Twitter') }}
                                </div>
                            </div>
                            <div class="mx-10">
                                <i class="fa-regular fa-arrow-right"></i>
                            </div>
                        </a>
                        <a class="share-items" href="https://www.facebook.com/sharer/sharer.php?u={{ url($post->slug) }}" target="_blank">
                            <div class="d-flex align-items-center">
                                <i class="fa-brands fa-facebook text-facebook font-20"></i>
                                <div class="ml-8">
                                    {{ ___('Share on Facebook') }}
                                </div>
                            </div>
                            <div class="mx-10">
                                <i class="fa-regular fa-arrow-right"></i>
                            </div>
                        </a>
                        <a class="share-items" href="https://web.whatsapp.com/send?text={{ url($post->slug) }}" target="_blank">
                            <div class="d-flex align-items-center">
                                <i class="fa-brands fa-whatsapp text-whatsapp font-20"></i>
                                <div class="ml-8">
                                    {{ ___('Share on Whatsapp') }}
                                </div>
                            </div>
                            <div class="mx-10">
                                <i class="fa-regular fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="copy-link-input d-flex position-relative w-100 mt-32">
                    <span class="position-absolute copy-input-icon fa-regular fa-link"></span>
                    <input class="w-100 copy-input font-14" type="text" value="{{ url($post->slug) }}" readonly>
                    <button class="copy-input-button font-weight-700 text-14" id="share-copy">  {{ ___('Copy') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('global/js/jquery.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/plugin/wow-animate/wow.min.js') }}"></script>
<script src="{{ asset('post_templates/template.js') }}"></script>
@stack('scripts_at_bottom')
</body>
</html>
