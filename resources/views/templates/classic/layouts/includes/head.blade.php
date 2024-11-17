<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="theme-color" content="{{ $settings->colors->primary_color }}">
@php
    $title = $__env->yieldContent('title') ? $__env->yieldContent('title') . ' - ' . @$settings->site_title : @$settings->site_title;
    $description = $__env->yieldContent('description') ? $__env->yieldContent('description') : @$settings->meta_description;

    $ogImage = $__env->yieldContent('og_image') ? $__env->yieldContent('og_image') : asset('storage/brand/'.$settings->media->social_image);
@endphp
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ @$settings->meta_keywords }}">
<link rel="alternate" hreflang="x-default" href="{{ url('/') }}" />
@if($settings->include_language_code)
    @foreach ($languages as $language)
        <link rel="alternate" hreflang="{{ $language->code }}" href="{{ url($language->code) }}" />
    @endforeach
@endif
<meta name="language" content="{{ get_lang() }}">
<meta name="author" content="{{ @$settings->site_title }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:site_name" content="{{ @$settings->site_title }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image:width" content="600">
<meta property="og:image:height" content="315">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:image:src" content="{{ $ogImage }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="theme" content="{{ active_theme_name() }}">
<title>{!! page_title($__env) !!}</title>
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/brand/'.$settings->media->favicon) }}">
