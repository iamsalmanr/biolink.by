@extends('post_templates.layout')
@section('content')
    <div class="bg-animation snow-bg-animation">
        <div class="min-vh-100 d-flex justify-content-center align-items-center">
            <div class="quick-bio-wrapper position-relative animated fadeIn">

                <img class="quick-bio-bg-image"
                     src="{{ asset('post_templates/'.$theme.'/image/snow.jpg') }}" alt="background"/>

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
                    <div id="particles-js"></div>
                    <div class="position-relative z-index-11">

                        <div class="d-flex position-absolute pb-0 sm-pb-24 justify-content-between">
                            <button class="button icon-group bg-white text-dark-1 dropdown-toggle size-35" type="button"
                                    data-bs-toggle="modal" data-bs-target="#share_social">
                                <i class="fa-regular fa-up-right-from-square font-14"></i>
                            </button>
                        </div>

                        <div class="bio-picture-wrapper bg-snow-theme">
                            <div class="bio-link-image mx-auto wow bounceIn" data-wow-delay="50ms">
                                <img class="" src="{{ asset('storage/post/logo/'.$post->image) }}"
                                     alt="{{ $post->title }}"
                                     role="presentation">
                            </div>
                        </div>

                        <h1 class="bio-title font-22 mt-16 text-center fw-bold wow fadeInDown"
                            data-wow-delay="200ms">{{ $post->title }}</h1>
                        <p class="bio-name font-18 mt-12 lh-lg text-center wow fadeInDown"
                           data-wow-delay="200ms">{{ $post->content }}</p>

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
                                                   data-wow-delay="{{ 400 * $i }}ms"><i
                                                        class="fa-regular fa-envelope"></i></a>
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
                </div>
                @php
                    $show = true;
                    if($post->user->plan_settings->hide_branding){
                        $show = (@$postOptions->bio_credit) ? true : false;
                    }
                @endphp
                @if($show)
                    <div class="quick-bio-logo text-center z-index-11">
                        <a target="_blank" aria-label="Biolink" rel="noopener nofollow" href="{{ url('/') }}">
                            <img class="h-30-px" src="{{  asset('storage/brand/logo_light_main.svg') }}"
                                 alt="{{ $settings->site_title }}">
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts_at_bottom')
        <script src="{{ asset($activeThemeAssets.'assets/plugin/particles/particles.min.js') }}"></script>
        <script>
            "use strict";
            particlesJS("particles-js", {
                particles: {
                    number: {
                        value: 500,
                        density: {
                            enable: true,
                            value_area: 631.3280775270874
                        }
                    },
                    color: {
                        value: "#fff"
                    },
                    shape: {
                        type: "circle",
                        stroke: {
                            width: 0,
                            color: "#000000"
                        },
                        polygon: {
                            nb_sides: 5
                        },
                        image: {
                            src: "img/github.svg",
                            width: 100,
                            height: 100
                        }
                    },
                    opacity: {
                        value: 0.8,
                        random: true,
                        anim: {
                            enable: false,
                            speed: 1,
                            opacity_min: 0.1,
                            sync: false
                        }
                    },
                    size: {
                        value: 5,
                        random: true,
                        anim: {
                            enable: false,
                            speed: 40,
                            size_min: 0.1,
                            sync: false
                        }
                    },
                    line_linked: {
                        enable: false,
                        distance: 500,
                        color: "#ffffff",
                        opacity: 0.4,
                        width: 2
                    },
                    move: {
                        enable: true,
                        speed: 3,
                        direction: "bottom",
                        random: false,
                        straight: false,
                        out_mode: "out",
                        bounce: false,
                        attract: {
                            enable: false,
                            rotateX: 600,
                            rotateY: 1200
                        }
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: {
                            enable: false,
                            mode: "bubble"
                        },
                        onclick: {
                            enable: true,
                            mode: "repulse"
                        },
                        resize: true
                    },
                    modes: {
                        grab: {
                            distance: 400,
                            line_linked: {
                                opacity: 0.5
                            }
                        },
                        bubble: {
                            distance: 400,
                            size: 4,
                            duration: 0.3,
                            opacity: 1,
                            speed: 3
                        },
                        repulse: {
                            distance: 200,
                            duration: 0.4
                        },
                        push: {
                            particles_nb: 4
                        },
                        remove: {
                            particles_nb: 2
                        }
                    }
                },
                retina_detect: true
            });

        </script>
    @endpush
@endsection
