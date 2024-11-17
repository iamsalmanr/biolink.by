@extends('post_templates.layout')
@section('content')
    <div class="bg-animation modern-bg-animation">
        <div class="min-vh-100 d-flex justify-content-center align-items-center">

            <div class="quick-bio-wrapper position-relative animated fadeIn">
                <img class="quick-bio-bg-image"
                     src="{{ asset('post_templates/'.$theme.'/image/bg.jpg') }}" alt="background"/>

                <div class="position-relative p-3">
                    @if(@$postOptions->cover_image)
                        <svg width="0" height="0" class="d-block">
                            <defs>
                                <clipPath id="myCurve" clipPathUnits="objectBoundingBox">
                                    <path d="M 0,1 L 0,0 L 1,0 L 1,1 C .65 .8, .35 .8, 0 1 Z"></path>
                                </clipPath>
                            </defs>
                        </svg>
                        <div class="bio-cover-image-wrapper wow fadeInDown">
                            <img alt="Cover" src="{{ asset('storage/post/logo/'.$postOptions->cover_image) }}">
                        </div>
                    @endif

                    <div
                        class="d-flex position-absolute pb-0 sm-pb-24 justify-content-between {{ (@$postOptions->bio_share) ? "" : "invisible" }}">
                        <button class="button icon-group bg-white text-dark-1 dropdown-toggle size-35 shadow-3"
                                type="button" data-bs-toggle="modal" data-bs-target="#share_social">
                            <i class="fa-regular fa-up-right-from-square font-14"></i>
                        </button>
                    </div>

                    <div class="bio-picture-wrapper bg-modern-theme">
                        <div class="bio-link-image mx-auto wow bounceIn" data-wow-delay="50ms">
                            <img class="" src="{{ asset('storage/post/logo/'.$post->image) }}" alt="{{ $post->title }}"
                                 role="presentation">
                        </div>
                    </div>

                    <h1 class="bio-title text-white font-22 mt-16 text-center fw-bold wow fadeInDown"
                        data-wow-delay="200ms">{{ $post->title }}</h1>
                    <p class="bio-name text-white font-18 mt-12 lh-lg text-center wow fadeInDown"
                       data-wow-delay="300ms">{{ $post->content }}</p>

                    @if ($bioLinks->count() > 0)
                        @php
                            $i = 0;
                            $limit = $post->user->plan_settings->biolink_limit;
                        @endphp
                        <div class="mt-24">
                        @foreach ($bioLinks as $bioLink)
                            @if ($bioLink->type == "header")
                                <!--HEADER-->
                                    <div
                                        class="quick-bio-link-heading mb-16 mt-32 text-center text-white font-16 fw-bold wow fadeInDown"
                                        data-wow-delay="{{ 400 * $i }}ms">{{ $bioLink->settings->title }}</div>
                            @endif

                            @if ($bioLink->type == "link" && $limit != -1 && $i < $limit)
                                <!--LINKS-->
                                    <div
                                        class="quick-bio-item wow fadeInDown @if ($bioLink->settings->highlight == 1) shake @endif"
                                        data-wow-delay="{{ 400 * $i }}ms">
                                        <a href="{{ $bioLink->settings->url }}"
                                           class="item-wrapper bg-white text-dark-1 shadow-3">
                                            @if ($bioLink->settings->logo != "")
                                                <div class="quick-bio-link-image">
                                                    <img
                                                        src="{{ asset('storage/post/biolink/'.$bioLink->settings->logo) }}"
                                                        alt="{{ $bioLink->settings->title }}">
                                                </div>
                                            @endif
                                            <div class="text-center">{{ $bioLink->settings->title }}</div>
                                        </a>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                @endif
                            @endforeach
                        </div>

                        <div class="d-flex align-items-center justify-content-center flex-wrap mt-32 pt-16">
                            @foreach ($bioLinks as $bioLink)
                                @if ($bioLink->type == "social")
                                    <div class="quick-social-icon mx-5 mb-10">
                                        @if ($bioLink->settings->title == "email")
                                            <a href="mailto:{{ $bioLink->settings->url }}"
                                               class="icon-group text-white font-30 wow fadeInDown"
                                               data-wow-delay="{{ 400 * $i }}ms"><i class="fa-regular fa-envelope"></i></a>
                                        @elseif ($bioLink->settings->title == "phone")
                                            <a href="tel:{{ $bioLink->settings->url }}"
                                               class="icon-group text-white font-30 wow fadeInDown"
                                               data-wow-delay="{{ 400 * $i }}ms"><i class="fa-regular fa-phone"></i></a>
                                        @else
                                            <a href="{{ $bioLink->settings->url }}"
                                               class="icon-group text-white font-30 wow fadeInDown"
                                               data-wow-delay="{{ 400 * $i }}ms"><i
                                                    class="fa-brands fa-{{ $bioLink->settings->title }}"></i></a>
                                        @endif

                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                </div>
                @php
                    $show = true;
                    if($post->user->plan_settings->hide_branding){
                        $show = (@$postOptions->bio_credit) ? true : false;
                    }
                @endphp
                @if($show)
                    <div class="quick-bio-logo text-center">
                        <a target="_blank" aria-label="Biolink" rel="noopener nofollow" href="{{ url('/') }}">
                            <img class="h-30-px" src="{{ asset('storage/brand/'.$settings->media->light_logo) }}"
                                 alt="{{ $settings->site_title }}">
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
