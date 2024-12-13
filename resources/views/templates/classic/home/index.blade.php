@extends($activeTheme.'layouts.main')
@section('navclass', 'nav-dark')
@section('content')

        <section class="hero-wrapper -style2">
            <div class="bg-dark-1 overflow-hidden">
                <div class="pt-180 pb-180 lg-pb-120 text-center position-relative">
                    <img src="{{ asset($activeThemeAssets.'assets/images/shape/spider-web-hero-bg.webp') }}" class="hero-bg-overlay-image position-absolute">
                    <div class="row position-relative mb-100 md-mb-0 lg-mb-30 px-20">
                        <div class="col-lg-8 col-xxl-7 mx-auto position-relative">
                            <div>
                                <h1 class="display-1 sm-font-50 md-font-60 mb-24 fw-bold text-white">
                                    {{ ___('Get Your BioLink in Seconds')  }}
                                </h1>
                                <p class="lead font-18 mb-24 text-light-3">{{ ___("Join 999+ people using Biolink for their link in bio. One link to help you share everything you are.")  }}</p>
                            </div>
                            <div class="d-flex justify-content-center" data-cues="slideInDown" data-delay="600">
                            <div class="position-relative">
                            <!-- Container for the text and input field aligned horizontally -->
                            <div class="d-flex align-items-center">
                                <!-- Fixed 'biolink.by/' text -->
                                <span class="text-white mr-4">biolink.by/</span>
                                
                                <!-- Input box for the username/handle -->
                                <input type="text" placeholder="Enter your handle" class="form-control bg-dark text-white border-0 shadow-sm" id="usernameInput" onchange="updateTryNowButton()" autocomplete="off" />
                                
                                <!-- Feedback message -->
                                <span id="username-feedback" class="text-danger d-none"><i class="fas fa-times-circle mx-2"></i></span>
                                <span id="username-available" class="text-success d-none">
                                    <i class="fas fa-check-circle mx-2"></i> 
                                </span>
                            </div>

                            <!-- Button that links to the register page -->
                            <a href="{{ route('register') }}" id="tryNowButton" class="button -primary h-48-px transform-none bg-transparent text-white border-2 mt-2"
                                style="border-color: rgb(34, 193, 195); transition: all 0.3s ease;">
                                <i class="fa-solid fa-stars mr-5"></i> {{ ___('Try Now') }}
                            </a>
    </div>
    </div>

                        <!-- /div -->
                    </div>
                    <!-- /column -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.container -->
    </section>
    <!-- /section Hero Cover Image-->
    <section class="d-none d-lg-block ml-2">
        <div class="container">
            <div class="hero-cover-image position-relative z-in-9">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-25 d-flex flex-column">
                        <img src="{{ asset($activeThemeAssets.'assets/images/screen/bio-social1.png') }}" class="w-100 h-auto rounded-3 shadow-2 mb-16">
                        <img src="{{ asset($activeThemeAssets.'assets/images/screen/bio-social.png') }}" class="w-100 h-auto rounded-3 shadow-2">
                    </div>
                    <div class="w-25">
                        <img src="{{ asset($activeThemeAssets.'assets/images/screen/bio-theme1.png') }}" class="w-100 h-auto rounded-3 shadow-2">
                    </div>
                    <div class="w-25">
                        <img src="{{ asset($activeThemeAssets.'assets/images/screen/bio-theme2.png') }}" class="w-100 h-auto rounded-3 shadow-2">
                    </div>

                    <div class="w-25 d-flex flex-column">
                        <img src="{{ asset($activeThemeAssets.'assets/images/screen/bio-profile.png') }}" class="w-100 h-auto rounded-3 shadow-2 mb-16">
                        <img src="{{ asset($activeThemeAssets.'assets/images/screen/bio-social2.png') }}" class="w-100 h-auto rounded-3 shadow-2">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /section  Hero Cover Image-->
    {!! ads_on_home_top() !!}
    <!-- / Section CTA Type 1-->
    <section class="pt-80 pb-120 lg-pb-80 mx-auto">
        <div class="cta-banner mx-auto  position-relative">
            <div class="container">
                <div class="row ml-2 g-5 align-items-start align-items-xl-center ml-4">
                    <div class="col-lg-7 col-xl-6 d-none d-lg-block">
                        <div class="position-relative mb-35 sm-mb-0 wow fadeInRight" data-wow-delay="300ms">
                            <div class="cta-widget item-box">
                                <h5 class="title mb-20"><span class="text-primary fw-semibold underbrush">{{ ___('Embed')  }}</span>
                                    {{ ___('Your Favorite Apps')  }}</h5>
                                <div class="d-flex  justify-content-between align-items-center bg-white py-2 px-3 border text-border-1 rounded-3 mb-16">
                                    <div class="d-flex align-items-center">
                                        <span class="pr-20 text-facebook"><i class="fa-brands fa-facebook"></i></span>
                                        <div class="text-capitalize font-16">{{ ___('Facebook')  }}</div>
                                    </div>
                                    <div class="drag-handle cursor-grab">
                                        <i class="fa-solid fa-grip-dots-vertical font-30 text-light-3"></i>
                                    </div>
                                </div>
                                <div class="d-flex  justify-content-between align-items-center bg-white py-2 px-3 border text-border-1 rounded-3 mb-16">
                                    <div class="d-flex align-items-center">
                                        <span class="pr-20 text-instagram"><i class="fa-brands fa-instagram"></i></span>
                                        <div class="text-capitalize font-16">{{ ___('Instagram')  }}</div>
                                    </div>
                                    <div class="drag-handle cursor-grab">
                                        <i class="fa-solid fa-grip-dots-vertical font-30 text-light-3"></i>
                                    </div>
                                </div>
                                <div class="d-flex  justify-content-between align-items-center bg-white py-2 px-3 border text-border-1 rounded-3 mb-16">
                                    <div class="d-flex align-items-center">
                                        <span class="pr-20 text-youtube"><i class="fa-brands fa-youtube"></i></span>
                                        <div class="text-capitalize font-16">{{ ___('Youtube')  }}</div>
                                    </div>
                                    <div class="drag-handle cursor-grab">
                                        <i class="fa-solid fa-grip-dots-vertical font-30 text-light-3"></i>
                                    </div>
                                </div>
                                <div class="d-flex  justify-content-between align-items-center bg-white py-2 px-3 border text-border-1 rounded-3">
                                    <div class="d-flex align-items-center">
                                        <span class="pr-20 text-twitter"><i class="fa-brands fa-twitter"></i></span>
                                        <div class="text-capitalize font-16">{{ ___('Twitter')  }}</div>
                                    </div>
                                    <div class="drag-handle cursor-grab">
                                        <i class="fa-solid fa-grip-dots-vertical font-30 text-light-3"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="cta-widget item-box -style2 d-none d-lg-block">
                                <h5 class="title mb-20 text-center">{{ ___('Manage All Links in')  }} <span class="text-primary fw-semibold underbrush">{{ ___('One Place')  }}</span></h5>
                                <div class="d-flex align-items-center  mb-16">
                                    <img src="{{ asset($activeThemeAssets.'assets/images/biolink-img/1.jpg') }}" alt="Image" class="size-50">
                                    <div class="ml-15">
                                        <div class="text-dark-1 font-14 fw-bold text-one-line word-break">
                                            {{ ___('Summer 2023')  }}
                                        </div>
                                        <div class="text font-14 text-one-line word-break">
                                            {{ ___('www.summerweb.com')  }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center  mb-16">
                                    <img src="{{ asset($activeThemeAssets.'assets/images/biolink-img/2.jpeg') }}" alt="Image" class="size-50">
                                    <div class="ml-15">
                                        <div class="text-dark-1 font-14 fw-bold text-one-line word-break">
                                            {{ ___('Spotify List')  }}
                                        </div>
                                        <div class="text font-14 text-one-line word-break">
                                            {{ ___('www.spotify.com/mylist')  }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center  mb-16">
                                    <img src="{{ asset($activeThemeAssets.'assets/images/biolink-img/3.jpeg') }}" alt="Image" class="size-50">
                                    <div class="ml-15">
                                        <div class="text-dark-1 font-14 fw-bold text-one-line word-break">
                                            {{ ___('Follow me on Insta')  }}
                                        </div>
                                        <div class="text font-14 text-one-line word-break">
                                            {{ ___('https://instagram.com/myinsta')  }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center ">
                                    <img src="{{ asset($activeThemeAssets.'assets/images/biolink-img/4.jpeg') }}" alt="Image" class="size-50">
                                    <div class="ml-15">
                                        <div class="text-dark-1 font-14 fw-bold text-one-line word-break">
                                            {{ ___('Fund Raise')  }}
                                        </div>
                                        <div class="text font-14 text-one-line word-break">
                                            {{ ___('www.donation.com')  }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <img class="d-block d-lg-none w-100" src="assets/images/" alt="">
                            <div class="imgbox position-relative d-none d-xl-block">
                                <img class="img-1 spin-right" src="{{ asset($activeThemeAssets.'assets/images/cta/element-1.png') }}" alt="">
                                <img class="img-2 bounce-x" src="{{ asset($activeThemeAssets.'assets/images/cta/element-2.png') }}" alt="">
                                <img class="img-3 bounce-y" src="{{ asset($activeThemeAssets.'assets/images/cta/element-3.png') }}" alt="">
                                <img class="img-4 bounce-y" src="{{ asset($activeThemeAssets.'assets/images/cta/element-4.png') }}" alt="">
                                <img class="img-5 spin-right" src="{{ asset($activeThemeAssets.'assets/images/cta/element-5.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5 col-xl-5 offset-xl-1 ">
                        <div class="mt-100 lg-mt-0 wow fadeInLeft" data-wow-delay="300ms">
                            <div class="badge bg-primary-l text-primary text-uppercase rounded-pill px-3 fw-bold font-12 py-2 mb-3">
                                {{ ___('Features')  }}
                            </div>
                            <h2 class="title mb10">{{ ___('Connect to Everything')  }} <br>{{ ___('You Love')  }}</h2>
                            <p class="text-dark-3 mb-25 md-mb-30"> {{ ___('Create social bio links for Instagram, YouTube, Twitter, Snapchat, Tiktok, Dribble and more.')  }}</p>
                            <div class="list-style3">
                                <ul>
                                    <li class="mb-20"><span
                                            class="size-20 bg-primary-l rounded-circle mr-5 d-inline-flex align-items-center justify-content-center">
                                            <i class="far fa-check text-primary font-12"></i></span> {{ ___('Easy to manage your links.')  }}
                                    </li>

                                    <li class="mb-20"><span
                                            class="size-20 bg-primary-l rounded-circle mr-5 d-inline-flex align-items-center justify-content-center">
                                            <i class="far fa-check text-primary font-12"></i></span> {{ ___('Create multiple bio links.')  }}
                                    </li>
                                    <li class="mb-20"><span
                                            class="size-20 bg-primary-l rounded-circle mr-5 d-inline-flex align-items-center justify-content-center">
                                            <i class="far fa-check text-primary font-12"></i></span> {{ ___('Share your link anywhere anytime.')  }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Section CTA Type 1-->
    <!-- /section Use Cases-->
    <!-- <section class="our-cases md-mb-80 mb-100">
        <div class="container theme-gradient-8 rounded-4 wow fadeInUp">
            <div class="p-5 py-60">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title text-center">
                            <div class="badge bg-primary-l text-primary text-uppercase rounded-pill px-3 fw-bold font-12 py-2 mb-3">
                                {{ ___('Use Cases')  }}
                            </div>
                            <h2>{{ ___('Unmatchable features.')  }}</h2>
                            <p class="text">{{ ___('Increase engagement while collecting leads with built-in forms.')  }}</p>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-sm-12 col-lg-4">
                        <div class="card h-100">
                            <div class="bg-primary-l size-60 rounded-4 font-30 d-flex align-items-center justify-content-center">
                                <i class="fa-regular fa-screwdriver-wrench"></i>
                            </div>
                            <div class="details pt-16">
                                <h4 class="title mt-16 mb-16">{{ ___('Create Bio Links')  }}</h4>
                                <p class="text">{{ ___('Easily create & manage all your links in one place: personal website, store, recent video or social post.')  }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-4">
                        <div class="card h-100">
                            <div class="bg-primary-l size-60 rounded-4 font-30 d-flex align-items-center justify-content-center">
                                <i class="fa-regular fa-user-pen"></i>
                            </div>
                            <div class="details pt-16">
                                <h4 class="title mt-16 mb-16">{{ ___('Share')  }}</h4>
                                <p class="text">{{ ___('Share your link on any social or digital platform: Instagram, YouTube, Facebook or TikTok, in messengers or via SMS.')  }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-4">
                        <div class="card h-100">
                            <div class="bg-primary-l size-60 rounded-4 font-30 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-rectangle-vertical-history"></i>
                            </div>
                            <div class="details pt-16">
                                <h4 class="title mt-16 mb-16">{{ ___('Multiple Layouts')  }}</h4>
                                <p class="text">{{ ___('Pick a theme or design your own to make sure your content pops. Your bio link does not have to be boring anymore.')  }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-4">
                        <div class="card h-100">
                            <div class="bg-primary-l size-60 rounded-4 font-30 d-flex align-items-center justify-content-center">
                                <i class="fa-regular fa-palette"></i>
                            </div>
                            <div class="details pt-16">
                                <h4 class="title mt-16 mb-16">{{ ___('Elegant And Perfect')  }}</h4>
                                <p class="text">{{ ___('With a cutting-edge interface, followers clicking on your Url will experience a great visual.')  }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-4">
                        <div class="card h-100">
                            <div class="bg-primary-l size-60 rounded-4 font-30 d-flex align-items-center justify-content-center">
                                <i class="fa-brands fa-edge"></i>
                            </div>
                            <div class="details pt-16">
                                <h4 class="title mt-16 mb-16">{{ ___('Web Based')  }}</h4>
                                <p class="text">{{ ___('No need to install anything, just access anytime via browser from any device.')  }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-4">
                        <div class="card h-100">
                            <div class="bg-primary-l size-60 rounded-4 font-30 d-flex align-items-center justify-content-center">
                                <i class="fa-regular fa-laptop-mobile"></i>
                            </div>
                            <div class="details pt-16">
                                <h4 class="title mt-16 mb-16">{{ ___('Fully Responsive')  }}</h4>
                                <p class="text">{{ ___('Yes, Quicklink gives you the biggest selection of visual layouts and all layouts are fully responsive so they look great on all devices.')  }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-4">
                        <div class="card h-100">
                            <div class="bg-primary-l size-60 rounded-4 font-30 d-flex align-items-center justify-content-center">
                                <i class="fa-regular fa-headset"></i>
                            </div>
                            <div class="details pt-16">
                                <h4 class="title mt-16 mb-16">{{ ___('SEO Friendly')  }}</h4>
                                <p class="text">{{ ___('Bring more organic traffic to your website with this SEO friendly feature.')  }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-4">
                        <div class="card h-100">
                            <div class="bg-primary-l size-60 rounded-4 font-30 d-flex align-items-center justify-content-center">
                                <i class="fa-regular fa-icons"></i>
                            </div>
                            <div class="details pt-16">
                                <h4 class="title mt-16 mb-16">{{ ___('Font Awesome 6 Pro Icons')  }}</h4>
                                <p class="text">{{ ___('All the icons are font based and ready to match the quality of any HQ screen.')  }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-4">
                        <div class="card h-100">
                            <div class="bg-primary-l size-60 rounded-4 font-30 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div class="details pt-16">
                                <h4 class="title mt-16 mb-16">{{ ___('Lifetime Update')  }}</h4>
                                <p class="text">{{ ___('We keep updating our products to stay up to date with latest trends and technology.')  }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- /section  Use Cases-->
    <!-- / Section CTA Type 2-->
    <div class="cta-banner -type3 mx-auto md-mb-80 mb-100 position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center  ml-4">
                <div class="col-lg-5 wow fadeInRight">
                    <div class="main-title mb-30">
                        <div class="badge bg-primary-l text-primary text-uppercase rounded-pill px-3 fw-bold font-12 py-2 mb-3">
                            {{ ___('Update Anytime')  }}
                        </div>
                        <h2 class="title">{{ ___('Make your links work for you')  }}</h2>
                        <p></p>
                    </div>
                    <div class="position-relative">
                        <div class="d-flex align-items-start mb-30">
                            <span class="flex-shrink-0 font-30 text-dark-3"><i
                                    class="fa-regular fa-badge-check"></i></span>
                            <div class="flex-grow-1 ml-20">
                                <h4 class="mb-1">{{ ___('Connect social')  }}</h4>
                                <p class="text-dark-3 mb-0 font-14">{{ ___('Seamlessly connect your Quick bio link with the tools you')  }}<br class="d-none d-lg-block"> {{ ___('already use.')  }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-30">
                            <span class="flex-shrink-0 font-30 text-dark-3"><i
                                    class="fa-regular fa-badge-check"></i></span>
                            <div class="flex-grow-1 ml-20">
                                <h4 class="mb-1">{{ ___('Choose your own')  }}</h4>
                                <p class="text-dark-3 mb-0 font-14">{{ ___('Customize your Quick bio link to match your brand. Make it')  }}<br class="d-none d-lg-block"> {{ ___('feel like you.')  }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-30">
                            <span class="flex-shrink-0 font-30 text-dark-3"><i
                                    class="fa-regular fa-badge-check"></i></span>
                            <div class="flex-grow-1 ml-20">
                                <h4 class="mb-1">{{ ___('Easy to manage')  }}</h4>
                                <p class="text-dark-3 mb-0 font-14">{{ ___('Add, Manage, and update content with our quick, easy editor.')  }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block offset-1">
                    <img class="wow fadeInLeft" src="{{ asset($activeThemeAssets.'assets/images/cta/cta2.png') }}" alt="call to action image" data-wow-delay="300ms">
                </div>
            </div>
        </div>
    </div>
    <!-- / Section CTA Type 2-->

    {{--Testimonials Section--}}
    @if ($testimonials->count() > 0)
        <section class="our-testimonials bg-danger-l md-mb-80 mb-100">
            <div class="container pt-100 pb-80 md-py-80 wow fadeInUp">
                <div class="row gx-xl-5 gy-5">
                    <div class="col-xl-4">
                        <div class="badge bg-primary-l text-primary text-uppercase rounded-pill px-3 fw-bold font-12 py-2 mb-3">
                            {{ ___('Testimonials')  }}
                        </div>
                        <h2 class="mt-10 mb-3">{{ ___('Our Community') }}</h2>
                        <p class="mb-6">{{ ___('Customer satisfaction is our major goal. See what our clients are saying about our services.') }}</p>
                        <a href="#" class="button -lg -primary rounded-pill font-18">{{ ___('All Testimonials') }}</a>
                    </div>
                    <!-- /column -->
                    <div class="col-xl-8">
                        <div class="reviews-slider3 owl-carousel owl-theme">
                            @foreach ($testimonials as $testimonial)
                                <div class="card">
                                    <div class="card-body">
                                        <blockquote class="icon mb-0">
                                            <p>“{{ !empty($testimonial->translations->{get_lang()}->content)
                                        ? $testimonial->translations->{get_lang()}->content
                                        : $testimonial->content }}”</p>
                                            <div class="blockquote-details d-flex align-items-center">
                                                <div class="w-50-px">
                                                    <img class="rounded-circle" src="{{ asset('storage/testimonials/'.$testimonial->image) }}" alt="{{ $testimonial->name }}" />
                                                </div>

                                                <div class="info ml-8">
                                                    <h5 class="mb-1">{{$testimonial->name}}</h5>
                                                    <p class="mb-0">
                                                        {{ !empty($testimonial->translations->{get_lang()}->designation)
                                                        ? $testimonial->translations->{get_lang()}->designation
                                                        : $testimonial->designation }}
                                                    </p>
                                                </div>
                                            </div>
                                        </blockquote>
                                    </div>
                                    <!--/.card-body -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{--Blog Section--}}
    @if ($settings->blog->status && $settings->blog->show_on_home && $blogArticles->count() > 0)
        <!--START -- Blog Grid style - on hover border dark and no shadow -- START-->
        <section class="our-blog md-mb-80 mb-100">
            <div class="container">
                <div class="row wow fadeInUp align-items-center">
                    <div class="col-lg-9">
                        <div class="main-title">
                            <div class="badge bg-primary-l text-primary text-uppercase rounded-pill px-3 fw-bold font-12 py-2 mb-3">
                                {{ ___('Blogs')  }}
                            </div>
                            <h2 class="title">{{ ___('Our Blog') }}</h2>
                            <p class="paragraph">{{ ___('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti esse reprehenderit voluptates obcaecati placeat architecto hic ratione ducimus nemo blog.') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="text-start text-lg-end mb-4">
                            <a class="button push-right" href="{{ route('blog.index') }}">{{ ___('Browse All') }}<i class="fal fa-arrow-right-long ml-5 push-this"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row wow fadeInUp" data-wow-delay="300ms">
                    @foreach ($blogArticles as $blogArticle)
                        <div class="col-sm-6 col-xl-3">
                            <div class="blog-wrap border border-1 -hover-dark shadow-none">
                                <div class="blog-img"><img  class="w-100" src="{{ asset('storage/blog/'.$blogArticle->image) }}" alt="{{ $blogArticle->title }}"></div>
                                <div class="blog-content">
                                    <a class="date" href="{{ route('blog.article', $blogArticle->slug) }}">{{ date_formating($blogArticle->created_at) }}</a>
                                    <h4 class="title mt-1"><a href="{{ route('blog.article', $blogArticle->slug) }}" class="text-decoration -underline">{{ $blogArticle->title }}</a></h4>
                                    <p class="text mb-0">{{ $blogArticle->short_description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{--FAQS Section--}}
    <!-- @if (@$settings->enable_faqs && $faqs->count() > 0)
        <section class="our-faq md-mb-80 mb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                        <div class="main-title text-center">
                            <div class="badge bg-primary-l text-primary text-uppercase rounded-pill px-3 fw-bold font-12 py-2 mb-3">
                                {{ ___('FAQs')  }}
                            </div>
                            <h2 class="title">{{ ___('Frequently Asked Questions') }}</h2>
                            <p class="paragraph mt10">{{ ___('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti esse reprehenderit voluptates obcaecati placeat architecto hic ratione ducimus nemo faq.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="row wow fadeInUp" data-wow-delay="300ms">
                    <div class="col-lg-8 mx-auto">
                        <div class="ui-content">
                            <div class="accordion -style2 faq-page mb-4 mb-lg-5">
                                <div class="accordion" id="accordionExample">
                                    @foreach ($faqs as $key => $faq)
                                        <div class="accordion-item @if($key == 0) active @endif">
                                            <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                                <button class="accordion-button @if($key != 0) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="" aria-controls="collapse{{ $faq->id }}">
                                                    {{ $faq->title }}
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse @if($key == 0) show @endif" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">{!! $faq->content !!}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif -->

    <section class="py-10  sm:py-16 lg:py-24  mx-2">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            
            <!-- Heading and Description -->
            <div class="max-w-6xl mx-auto text-center aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
                <h2 class="mt-2 text-3xl font-bold leading-tight text-black sm:text-4xl lg:text-5xl text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 to-blue-600">
                    Create your BioLink in 5 minutes on mobile!
                </h2>
                <p class="max-w-lg mx-auto mt-4 text-base leading-relaxed text-gray-600">
                    Register for free, build and manage your BioLinks anywhere, anytime, on the go — without limits.
                </p>
            </div>
            
            <!-- Steps Section -->
            <div class="relative mt-12 lg:mt-20">
                <!-- Decorative Dotted Line (Visible on Larger Screens) -->
                <div class="absolute inset-x-0 hidden xl:px-44 top-2 md:block md:px-20 lg:px-28">
                    <img class="w-full" src="https://web.biolinks.com/cores/58/tpl/links/img/dotted-line.svg" alt="">
                </div>

                <!-- Step Cards -->
                <div class="relative grid grid-cols-1 text-center gap-y-12 md:grid-cols-3 gap-x-12">
                    
                    <!-- Step 1 -->
                    <div class="aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-gray-200 rounded-full shadow">
                            <span class="text-xl font-semibold text-gray-700">1</span>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold leading-tight text-black md:mt-10">Get your BioLink</h3>
                        <p class="mt-4 text-base text-gray-600">
                            Create a free account and choose a personalized BioLinks URL to maintain your brand identity.
                        </p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="300">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-gray-200 rounded-full shadow">
                            <span class="text-xl font-semibold text-gray-700">2</span>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold leading-tight text-black md:mt-10">Customize &amp; Design</h3>
                        <p class="mt-4 text-base text-gray-600">
                            Add all your social profile links and embed your social content to grow your follower base across social networks.
                        </p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="600">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-gray-200 rounded-full shadow">
                            <span class="text-xl font-semibold text-gray-700">3</span>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold leading-tight text-black md:mt-10">Share &amp; Grow</h3>
                        <p class="mt-4 text-base text-gray-600">
                            Share your BioLink page across all your social profiles, making it easy for users to find and follow you everywhere.
                        </p>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </section>

    <section class="our-cta md-mb-80 mb-10  mx-2" >
            <section class="py-12 bg-gray-50 sm:py-16 lg:py-20">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center">
                    
                    <!-- Profile Images -->
                    <div class="text-center flex justify-center flex-shrink-0 -space-x-4 overflow-hidden mb-4 aos-init aos-animate" 
                        data-aos="fade-up" data-aos-duration="1200">
                        <img class="inline-block rounded-full w-14 h-14 ring-2 ring-white" src="https://web.biolinks.com/cores/58/tpl/links/img/14.jpg" alt="">
                        <img class="inline-block rounded-full w-14 h-14 ring-2 ring-white" src="https://web.biolinks.com/cores/58/tpl/links/img/12.jpg" alt="">
                        <img class="inline-block rounded-full w-14 h-14 ring-2 ring-white" src="https://web.biolinks.com/cores/58/tpl/links/img/13.jpg" alt="">
                        <img class="inline-block rounded-full w-14 h-14 ring-2 ring-white" src="https://web.biolinks.com/cores/58/tpl/links/img/11.jpg" alt="">
                        <img class="inline-block rounded-full w-14 h-14 ring-2 ring-white" src="https://web.biolinks.com/cores/58/tpl/links/img/10.jpg" alt="">
                        <img class="inline-block rounded-full w-14 h-14 ring-2 ring-white" src="https://web.biolinks.com/cores/58/tpl/links/img/9.jpg" alt="">
                        <img class="inline-block rounded-full w-14 h-14 ring-2 ring-white" src="https://web.biolinks.com/cores/58/tpl/links/img/8.jpg" alt="">
                        
                        <!-- Add Icon -->
                        <div class="inline-flex items-center justify-center bg-gray-100 rounded-full w-14 h-14 ring-2 ring-white">
                            <svg class="w-5 h-5 text-gray-900" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" 
                                    d="M10 3C10.5523 3 11 3.44772 11 4V9H16C16.5523 9 17 9.44772 17 10C17 10.5523 16.5523 11 16 11H11V16C11 16.5523 10.5523 17 10 17C9.44772 17 9 16.5523 9 16V11H4C3.44772 11 3 10.5523 3 10C3 9.44771 3.44772 9 4 9L9 9V4C9 3.44772 9.44772 3 10 3Z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Heading and Description -->
                    <h2 class="text-4xl font-bold text-gray-900 font-pj aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200">
                        Join ⚡️ BioLink community
                    </h2>
                    <p class="max-w-md mx-auto mt-5 text-base font-normal text-gray-600 font-pj aos-init aos-animate" 
                    data-aos="fade-up" data-aos-duration="1200">
                        Become a BioLink fan! We've built a tool that helps you achieve your goals and grow your social community using the best Bio Link tool on the market.
                    </p>
                </div>

                <!-- Call to Action Button -->
                <div class="max-w-lg mx-auto mt-14 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200">
                    <div class="mt-4 mt-0 inset-y-0 right-0 items-center pr-3">
                        <a href="https://app.biolinks.com/create" target="_blank">
                            <div class="flex justify-center">
                            <button type="submit" class="items-center w-full px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-gray-900 border border-transparent w-auto sm:py-3 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 font-pj hover:bg-opacity-90 rounded-xl">
                                Try it now!
                            </button>
                            </div>

                        </a>
                    </div>
                </div>
                
                <!-- Footer Note -->
                <p class="mt-6 text-lg font-normal text-center text-gray-500 font-pj">
                    Don't miss your chance — try it now!
                </p>
            </div>
    </section>




    </section>

    {!! ads_on_home_bottom() !!}
@endsection


<style>		*, ::after, ::before {			box-sizing: border-box;			border-width: 0;			border-style: solid;			border-color: #e5e7eb		}		::after, ::before {			--tw-content: ''		}		:host, html {			line-height: 1.5;			-webkit-text-size-adjust: 100%;			-moz-tab-size: 4;			tab-size: 4;			font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";			font-feature-settings: normal;			font-variation-settings: normal;			-webkit-tap-highlight-color: transparent		}		body {			margin: 0;			line-height: inherit		}		hr {			height: 0;			color: inherit;			border-top-width: 1px		}		abbr:where([title]) {			-webkit-text-decoration: underline dotted;			text-decoration: underline dotted		}		h1, h2, h3, h4, h5, h6 {			font-size: inherit;			font-weight: inherit		}		a {			color: inherit;			text-decoration: inherit		}		b, strong {			font-weight: bolder		}		code, kbd, pre, samp {			font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;			font-feature-settings: normal;			font-variation-settings: normal;			font-size: 1em		}		small {			font-size: 80%		}		sub, sup {			font-size: 75%;			line-height: 0;			position: relative;			vertical-align: baseline		}		sub {			bottom: -.25em		}		sup {			top: -.5em		}		table {			text-indent: 0;			border-color: inherit;			border-collapse: collapse		}		button, input, optgroup, select, textarea {			font-family: inherit;			font-feature-settings: inherit;			font-variation-settings: inherit;			font-size: 100%;			font-weight: inherit;			line-height: inherit;			letter-spacing: inherit;			color: inherit;			margin: 0;			padding: 0		}		button, select {			text-transform: none		}		button, input:where([type=button]), input:where([type=reset]), input:where([type=submit]) {			-webkit-appearance: button;			background-color: transparent;			background-image: none		}		:-moz-focusring {			outline: auto		}		:-moz-ui-invalid {			box-shadow: none		}		progress {			vertical-align: baseline		}		::-webkit-inner-spin-button, ::-webkit-outer-spin-button {			height: auto		}		[type=search] {			-webkit-appearance: textfield;			outline-offset: -2px		}		::-webkit-search-decoration {			-webkit-appearance: none		}		::-webkit-file-upload-button {			-webkit-appearance: button;			font: inherit		}		summary {			display: list-item		}		blockquote, dd, dl, figure, h1, h2, h3, h4, h5, h6, hr, p, pre {			margin: 0		}		fieldset {			margin: 0;			padding: 0		}		legend {			padding: 0		}		menu, ol, ul {			list-style: none;			margin: 0;			padding: 0		}		dialog {			padding: 0		}		textarea {			resize: vertical		}		input::placeholder, textarea::placeholder {			opacity: 1;			color: #9ca3af		}		[role=button], button {			cursor: pointer		}		:disabled {			cursor: default		}		audio, canvas, embed, iframe, img, object, svg, video {			display: block;			vertical-align: middle		}		img, video {			max-width: 100%;			height: auto		}		[hidden] {			display: none		}		*, ::before, ::after {			--tw-border-spacing-x: 0;			--tw-border-spacing-y: 0;			--tw-translate-x: 0;			--tw-translate-y: 0;			--tw-rotate: 0;			--tw-skew-x: 0;			--tw-skew-y: 0;			--tw-scale-x: 1;			--tw-scale-y: 1;			--tw-pan-x: ;			--tw-pan-y: ;			--tw-pinch-zoom: ;			--tw-scroll-snap-strictness: proximity;			--tw-gradient-from-position: ;			--tw-gradient-via-position: ;			--tw-gradient-to-position: ;			--tw-ordinal: ;			--tw-slashed-zero: ;			--tw-numeric-figure: ;			--tw-numeric-spacing: ;			--tw-numeric-fraction: ;			--tw-ring-inset: ;			--tw-ring-offset-width: 0px;			--tw-ring-offset-color: #fff;			--tw-ring-color: rgb(59 130 246 / 0.5);			--tw-ring-offset-shadow: 0 0 #0000;			--tw-ring-shadow: 0 0 #0000;			--tw-shadow: 0 0 #0000;			--tw-shadow-colored: 0 0 #0000;			--tw-blur: ;			--tw-brightness: ;			--tw-contrast: ;			--tw-grayscale: ;			--tw-hue-rotate: ;			--tw-invert: ;			--tw-saturate: ;			--tw-sepia: ;			--tw-drop-shadow: ;			--tw-backdrop-blur: ;			--tw-backdrop-brightness: ;			--tw-backdrop-contrast: ;			--tw-backdrop-grayscale: ;			--tw-backdrop-hue-rotate: ;			--tw-backdrop-invert: ;			--tw-backdrop-opacity: ;			--tw-backdrop-saturate: ;			--tw-backdrop-sepia: ;			--tw-contain-size: ;			--tw-contain-layout: ;			--tw-contain-paint: ;			--tw-contain-style:		}		::backdrop {			--tw-border-spacing-x: 0;			--tw-border-spacing-y: 0;			--tw-translate-x: 0;			--tw-translate-y: 0;			--tw-rotate: 0;			--tw-skew-x: 0;			--tw-skew-y: 0;			--tw-scale-x: 1;			--tw-scale-y: 1;			--tw-pan-x: ;			--tw-pan-y: ;			--tw-pinch-zoom: ;			--tw-scroll-snap-strictness: proximity;			--tw-gradient-from-position: ;			--tw-gradient-via-position: ;			--tw-gradient-to-position: ;			--tw-ordinal: ;			--tw-slashed-zero: ;			--tw-numeric-figure: ;			--tw-numeric-spacing: ;			--tw-numeric-fraction: ;			--tw-ring-inset: ;			--tw-ring-offset-width: 0px;			--tw-ring-offset-color: #fff;			--tw-ring-color: rgb(59 130 246 / 0.5);			--tw-ring-offset-shadow: 0 0 #0000;			--tw-ring-shadow: 0 0 #0000;			--tw-shadow: 0 0 #0000;			--tw-shadow-colored: 0 0 #0000;			--tw-blur: ;			--tw-brightness: ;			--tw-contrast: ;			--tw-grayscale: ;			--tw-hue-rotate: ;			--tw-invert: ;			--tw-saturate: ;			--tw-sepia: ;			--tw-drop-shadow: ;			--tw-backdrop-blur: ;			--tw-backdrop-brightness: ;			--tw-backdrop-contrast: ;			--tw-backdrop-grayscale: ;			--tw-backdrop-hue-rotate: ;			--tw-backdrop-invert: ;			--tw-backdrop-opacity: ;			--tw-backdrop-saturate: ;			--tw-backdrop-sepia: ;			--tw-contain-size: ;			--tw-contain-layout: ;			--tw-contain-paint: ;			--tw-contain-style:		}		.absolute {			position: absolute		}		.relative {			position: relative		}		.-inset-1 {			inset: -0.25rem		}		.-inset-x-2 {			left: -0.5rem;			right: -0.5rem		}		.-inset-y-5 {			top: -1.25rem;			bottom: -1.25rem		}		.inset-x-0 {			left: 0px;			right: 0px		}		.bottom-0 {			bottom: 0px		}		.right-0 {			right: 0px		}		.top-2 {			top: 0.5rem		}		.top-36 {			top: 9rem		}		.mx-8 {			margin-left: 2rem;			margin-right: 2rem		}		.mx-auto {			margin-left: auto;			margin-right: auto		}		.mb-4 {			margin-bottom: 1rem		}		.ml-5 {			margin-left: 1.25rem		}		.mr-4 {			margin-right: 1rem		}		.mr-auto {			margin-right: auto		}		.mt-12 {			margin-top: 3rem		}		.mt-14 {			margin-top: 3.5rem		}		.mt-4 {			margin-top: 1rem		}		.mt-5 {			margin-top: 1.25rem		}		.mt-6 {			margin-top: 1.5rem		}		.mt-8 {			margin-top: 2rem		}		.mt-px {			margin-top: 1px		}		.block {			display: block		}		.inline-block {			display: inline-block		}		.flex {			display: flex		}		.inline-flex {			display: inline-flex		}		.grid {			display: grid		}		.hidden {			display: none		}		.h-14 {			height: 3.5rem		}		.h-16 {			height: 4rem		}		.h-5 {			height: 1.25rem		}		.h-6 {			height: 1.5rem		}		.h-auto {			height: auto		}		.h-full {			height: 100%		}		.w-12 {			width: 3rem		}		.w-14 {			width: 3.5rem		}		.w-16 {			width: 4rem		}		.w-5 {			width: 1.25rem		}		.w-6 {			width: 1.5rem		}		.w-auto {			width: auto		}		.w-full {			width: 100%		}		.max-w-2xl {			max-width: 42rem		}		.max-w-3xl {			max-width: 48rem		}		.max-w-4xl {			max-width: 56rem		}		.max-w-6xl {			max-width: 72rem		}		.max-w-7xl {			max-width: 80rem		}		.max-w-lg {			max-width: 32rem		}		.max-w-md {			max-width: 28rem		}		.max-w-sm {			max-width: 24rem		}		.max-w-xl {			max-width: 36rem		}		.flex-shrink-0 {			flex-shrink: 0		}		.rotate-180 {			--tw-rotate: 180deg;			transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))		}		.scale-110 {			--tw-scale-x: 1.1;			--tw-scale-y: 1.1;			transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))		}		.grid-cols-1 {			grid-template-columns:repeat(1, minmax(0, 1fr))		}		.flex-col {			flex-direction: column		}		.items-center {			align-items: center		}		.justify-center {			justify-content: center		}		.justify-between {			justify-content: space-between		}		.gap-6 {			gap: 1.5rem		}		.gap-x-12 {			column-gap: 3rem		}		.gap-y-12 {			row-gap: 3rem		}		.gap-y-8 {			row-gap: 2rem		}		.-space-x-4 > :not([hidden]) ~ :not([hidden]) {			--tw-space-x-reverse: 0;			margin-right: calc(-1rem * var(--tw-space-x-reverse));			margin-left: calc(-1rem * calc(1 - var(--tw-space-x-reverse)))		}		.overflow-hidden {			overflow: hidden		}		.rounded {			border-radius: 0.25rem		}		.rounded-full {			border-radius: 9999px		}		.rounded-lg {			border-radius: 0.5rem		}		.rounded-xl {			border-radius: 0.75rem		}		.border {			border-width: 1px		}		.border-2 {			border-width: 2px		}		.border-gray-200 {			--tw-border-opacity: 1;			border-color: rgb(229 231 235 / var(--tw-border-opacity))		}		.border-gray-400 {			--tw-border-opacity: 1;			border-color: rgb(156 163 175 / var(--tw-border-opacity))		}		.border-gray-500 {			--tw-border-opacity: 1;			border-color: rgb(107 114 128 / var(--tw-border-opacity))		}		.border-gray-900 {			--tw-border-opacity: 1;			border-color: rgb(17 24 39 / var(--tw-border-opacity))		}		.border-transparent {			border-color: transparent		}		.bg-gray-50 {			--tw-bg-opacity: 1;			background-color: rgb(249 250 251 / var(--tw-bg-opacity))		}		.bg-gray-100 {			--tw-bg-opacity: 1;			background-color: rgb(243 244 246 / var(--tw-bg-opacity))		}		.bg-gray-900 {			--tw-bg-opacity: 1;			background-color: rgb(17 24 39 / var(--tw-bg-opacity))		}		.bg-transparent {			background-color: transparent		}		.bg-white {			--tw-bg-opacity: 1;			background-color: rgb(255 255 255 / var(--tw-bg-opacity))		}		.bg-gradient-to-r {			background-image: linear-gradient(to right, var(--tw-gradient-stops))		}		.from-fuchsia-600 {			--tw-gradient-from: #c026d3 var(--tw-gradient-from-position);			--tw-gradient-to: rgb(192 38 211 / 0) var(--tw-gradient-to-position);			--tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)		}		.to-blue-600 {			--tw-gradient-to: #2563eb var(--tw-gradient-to-position)		}		.bg-clip-text {			-webkit-background-clip: text;			background-clip: text		}		.object-contain {			object-fit: contain		}		.p-2 {			padding: 0.5rem		}		.p-8 {			padding: 2rem		}		.px-4 {			padding-left: 1rem;			padding-right: 1rem		}		.px-5 {			padding-left: 1.25rem;			padding-right: 1.25rem		}		.px-6 {			padding-left: 1.5rem;			padding-right: 1.5rem		}		.px-8 {			padding-left: 2rem;			padding-right: 2rem		}		.py-10 {			padding-top: 2.5rem;			padding-bottom: 2.5rem		}		.py-12 {			padding-top: 3rem;			padding-bottom: 3rem		}		.py-2 {			padding-top: 0.5rem;			padding-bottom: 0.5rem		}		.py-3 {			padding-top: 0.75rem;			padding-bottom: 0.75rem		}		.py-4 {			padding-top: 1rem;			padding-bottom: 1rem		}		.py-6 {			padding-top: 1.5rem;			padding-bottom: 1.5rem		}		.pt-16 {			padding-top: 4rem		}		.text-center {			text-align: center		}		.text-3xl {			font-size: 1.875rem;			line-height: 2.25rem		}		.text-4xl {			font-size: 2.25rem;			line-height: 2.5rem		}		.text-base {			font-size: 1rem;			line-height: 1.5rem		}		.text-lg {			font-size: 1.125rem;			line-height: 1.75rem		}		.text-sm {			font-size: 0.875rem;			line-height: 1.25rem		}		.text-xl {			font-size: 1.25rem;			line-height: 1.75rem		}		.font-bold {			font-weight: 700		}		.font-medium {			font-weight: 500		}		.font-normal {			font-weight: 400		}		.font-semibold {			font-weight: 600		}		.leading-7 {			line-height: 1.75rem		}		.leading-relaxed {			line-height: 1.625		}		.leading-tight {			line-height: 1.25		}		.text-black {			--tw-text-opacity: 1;			color: rgb(0 0 0 / var(--tw-text-opacity))		}		.text-blue-600 {			--tw-text-opacity: 1;			color: rgb(37 99 235 / var(--tw-text-opacity))		}		.text-gray-500 {			--tw-text-opacity: 1;			color: rgb(107 114 128 / var(--tw-text-opacity))		}		.text-gray-600 {			--tw-text-opacity: 1;			color: rgb(75 85 99 / var(--tw-text-opacity))		}		.text-gray-700 {			--tw-text-opacity: 1;			color: rgb(55 65 81 / var(--tw-text-opacity))		}		.text-gray-900 {			--tw-text-opacity: 1;			color: rgb(17 24 39 / var(--tw-text-opacity))		}		.text-transparent {			color: transparent		}		.text-white {			--tw-text-opacity: 1;			color: rgb(255 255 255 / var(--tw-text-opacity))		}		.placeholder-gray-600::placeholder {			--tw-placeholder-opacity: 1;			color: rgb(75 85 99 / var(--tw-placeholder-opacity))		}		.placeholder-gray-900::placeholder {			--tw-placeholder-opacity: 1;			color: rgb(17 24 39 / var(--tw-placeholder-opacity))		}		.opacity-20 {			opacity: 0.2		}		.opacity-30 {			opacity: 0.3		}		.shadow {			--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);			--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);			box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)		}		.outline-none {			outline: 2px solid transparent;			outline-offset: 2px		}		.ring-2 {			--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);			--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);			box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)		}		.ring-white {			--tw-ring-opacity: 1;			--tw-ring-color: rgb(255 255 255 / var(--tw-ring-opacity))		}		.blur-lg {			--tw-blur: blur(16px);			filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)		}		.drop-shadow-lg {			--tw-drop-shadow: drop-shadow(0 10px 8px rgb(0 0 0 / 0.04)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.1));			filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)		}		.filter {			filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)		}		.transition-all {			transition-property: all;			transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);			transition-duration: 150ms		}		.duration-200 {			transition-duration: 200ms		}		.hover\:bg-gray-600:hover {			--tw-bg-opacity: 1;			background-color: rgb(75 85 99 / var(--tw-bg-opacity))		}		.hover\:bg-gray-900:hover {			--tw-bg-opacity: 1;			background-color: rgb(17 24 39 / var(--tw-bg-opacity))		}		.hover\:bg-opacity-90:hover {			--tw-bg-opacity: 0.9		}		.hover\:text-white:hover {			--tw-text-opacity: 1;			color: rgb(255 255 255 / var(--tw-text-opacity))		}		.hover\:text-opacity-50:hover {			--tw-text-opacity: 0.5		}		.focus\:border-black:focus {			--tw-border-opacity: 1;			border-color: rgb(0 0 0 / var(--tw-border-opacity))		}		.focus\:border-gray-900:focus {			--tw-border-opacity: 1;			border-color: rgb(17 24 39 / var(--tw-border-opacity))		}		.focus\:bg-gray-600:focus {			--tw-bg-opacity: 1;			background-color: rgb(75 85 99 / var(--tw-bg-opacity))		}		.focus\:bg-gray-900:focus {			--tw-bg-opacity: 1;			background-color: rgb(17 24 39 / var(--tw-bg-opacity))		}		.focus\:text-white:focus {			--tw-text-opacity: 1;			color: rgb(255 255 255 / var(--tw-text-opacity))		}		.focus\:outline-none:focus {			outline: 2px solid transparent;			outline-offset: 2px		}		.focus\:ring-1:focus {			--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);			--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);			box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)		}		.focus\:ring-2:focus {			--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);			--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);			box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)		}		.focus\:ring-black:focus {			--tw-ring-opacity: 1;			--tw-ring-color: rgb(0 0 0 / var(--tw-ring-opacity))		}		.focus\:ring-gray-900:focus {			--tw-ring-opacity: 1;			--tw-ring-color: rgb(17 24 39 / var(--tw-ring-opacity))		}		.focus\:ring-offset-2:focus {			--tw-ring-offset-width: 2px		}		@media (min-width: 640px) {			.sm\:absolute {				position: absolute			}			.sm\:inset-y-0 {				top: 0px;				bottom: 0px			}			.sm\:right-0 {				right: 0px			}			.sm\:mt-0 {				margin-top: 0px			}			.sm\:mt-10 {				margin-top: 2.5rem			}			.sm\:flex {				display: flex			}			.sm\:w-auto {				width: auto			}			.sm\:max-w-md {				max-width: 28rem			}			.sm\:grid-cols-2 {				grid-template-columns:repeat(2, minmax(0, 1fr))			}			.sm\:items-center {				align-items: center			}			.sm\:gap-y-20 {				row-gap: 5rem			}			.sm\:rounded-xl {				border-radius: 0.75rem			}			.sm\:border {				border-width: 1px			}			.sm\:border-none {				border-style: none			}			.sm\:border-gray-500 {				--tw-border-opacity: 1;				border-color: rgb(107 114 128 / var(--tw-border-opacity))			}			.sm\:px-0 {				padding-left: 0px;				padding-right: 0px			}			.sm\:px-6 {				padding-left: 1.5rem;				padding-right: 1.5rem			}			.sm\:py-16 {				padding-top: 4rem;				padding-bottom: 4rem			}			.sm\:py-3 {				padding-top: 0.75rem;				padding-bottom: 0.75rem			}			.sm\:pr-2 {				padding-right: 0.5rem			}			.sm\:pr-3 {				padding-right: 0.75rem			}			.sm\:text-4xl {				font-size: 2.25rem;				line-height: 2.5rem			}			.sm\:text-5xl {				font-size: 3rem;				line-height: 1			}			.sm\:leading-tight {				line-height: 1.25			}			.sm\:focus-within\:border-gray-900:focus-within {				--tw-border-opacity: 1;				border-color: rgb(17 24 39 / var(--tw-border-opacity))			}			.sm\:focus-within\:ring-1:focus-within {				--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);				--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);				box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)			}			.sm\:focus-within\:ring-gray-900:focus-within {				--tw-ring-opacity: 1;				--tw-ring-color: rgb(17 24 39 / var(--tw-ring-opacity))			}			.sm\:focus\:border-transparent:focus {				border-color: transparent			}			.sm\:focus\:ring-0:focus {				--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);				--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color);				box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)			}		}		@media (min-width: 768px) {			.md\:mx-0 {				margin-left: 0px;				margin-right: 0px			}			.md\:mt-10 {				margin-top: 2.5rem			}			.md\:mt-20 {				margin-top: 5rem			}			.md\:block {				display: block			}			.md\:max-w-full {				max-width: 100%			}			.md\:max-w-none {				max-width: none			}			.md\:grid-cols-3 {				grid-template-columns:repeat(3, minmax(0, 1fr))			}			.md\:gap-x-16 {				column-gap: 4rem			}			.md\:px-16 {				padding-left: 4rem;				padding-right: 4rem			}			.md\:px-20 {				padding-left: 5rem;				padding-right: 5rem			}			.md\:py-6 {				padding-top: 1.5rem;				padding-bottom: 1.5rem			}			.md\:text-left {				text-align: left			}		}		@media (min-width: 1024px) {			.lg\:inset-y-0 {				top: 0px;				bottom: 0px			}			.lg\:ml-4 {				margin-left: 1rem			}			.lg\:mt-0 {				margin-top: 0px			}			.lg\:mt-12 {				margin-top: 3rem			}			.lg\:mt-16 {				margin-top: 4rem			}			.lg\:mt-20 {				margin-top: 5rem			}			.lg\:flex {				display: flex			}			.lg\:grid-cols-2 {				grid-template-columns:repeat(2, minmax(0, 1fr))			}			.lg\:grid-cols-3 {				grid-template-columns:repeat(3, minmax(0, 1fr))			}			.lg\:items-center {				align-items: center			}			.lg\:justify-start {				justify-content: flex-start			}			.lg\:px-0 {				padding-left: 0px;				padding-right: 0px			}			.lg\:px-28 {				padding-left: 7rem;				padding-right: 7rem			}			.lg\:px-8 {				padding-left: 2rem;				padding-right: 2rem			}			.lg\:py-20 {				padding-top: 5rem;				padding-bottom: 5rem			}			.lg\:py-24 {				padding-top: 6rem;				padding-bottom: 6rem			}			.lg\:text-left {				text-align: left			}			.lg\:text-4xl {				font-size: 2.25rem;				line-height: 2.5rem			}			.lg\:text-5xl {				font-size: 3rem;				line-height: 1			}			.lg\:leading-tight {				line-height: 1.25			}		}		@media (min-width: 1280px) {			.xl\:col-span-2 {				grid-column: span 2 / span 2			}			.xl\:col-span-3 {				grid-column: span 3 / span 3			}			.xl\:block {				display: block			}			.xl\:grid-cols-5 {				grid-template-columns:repeat(5, minmax(0, 1fr))			}			.xl\:gap-10 {				gap: 2.5rem			}			.xl\:gap-x-32 {				column-gap: 8rem			}			.xl\:px-44 {				padding-left: 11rem;				padding-right: 11rem			}			.xl\:text-5xl {				font-size: 3rem;				line-height: 1			}		}	</style>
<style>@font-face {
              font-family: 'Open Sans Regular';
              font-style: normal;
              font-weight: 400;
              src: url('chrome-extension://gkkdmjjodidppndkbkhhknakbeflbomf/fonts/open_sans/open-sans-v18-latin-regular.woff');
          }</style>
<style>@font-face {
              font-family: 'Open Sans Bold';
              font-style: normal;
              font-weight: 800;
              src: url('chrome-extension://gkkdmjjodidppndkbkhhknakbeflbomf/fonts/open_sans/OpenSans-Bold.woff');
          }</style>

<style>@font-face {
              font-family: 'Open Sans ExtraBold';
              font-style: normal;
              font-weight: 800;
              src: url('chrome-extension://gkkdmjjodidppndkbkhhknakbeflbomf/fonts/open_sans/open-sans-v18-latin-800.woff');
          }</style>

<style>
    /* Button base styles */
.button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    text-align: center;
    text-decoration: none;
    border-radius: 50px; /* Rounded button */
    font-size: 16px;
    font-weight: bold;
    background-color: transparent;
    color: white;
    border: 2px solid rgb(34, 193, 195); /* RGB Border Color */
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
}

/* Adding a shadow effect on hover */
.button:hover {
    background-color: rgb(34, 193, 195); /* RGB Hover Background */
    color: white;
    border-color: rgb(34, 193, 195); /* Matching border color on hover */
    box-shadow: 0 4px 20px rgba(34, 193, 195, 0.5); /* Soft shadow */
}

/* Adding a subtle glowing effect */
.button:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    background-color: rgba(34, 193, 195, 0.2); /* Soft glow */
    border-radius: 50%;
    transition: all 0.6s ease;
    transform: translate(-50%, -50%);
    z-index: 0;
}

/* Make the glow appear on hover */
.button:hover:before {
    width: 400%;
    height: 400%;
    opacity: 0;
}

/* Icon Styling for a better appearance */
.button i {
    font-size: 18px; /* Slightly larger icon */
    transition: all 0.3s ease;
}

/* Animating icon on hover */
.button:hover i {
    transform: translateX(5px); /* Slight animation effect on icon */
}



</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const usernameInput = document.getElementById('usernameInput');
    const feedbackTaken = document.getElementById('username-feedback');
    const feedbackAvailable = document.getElementById('username-available');

    // Create a warning message for username length
    const warningMessage = document.createElement('span');
    warningMessage.classList.add('text-warning', 'd-none');
    warningMessage.innerHTML = '<i class="fas fa-exclamation-circle mx-2"></i> Minimum length 3';
    usernameInput.insertAdjacentElement('afterend', warningMessage);

    if (usernameInput) {
        usernameInput.addEventListener('input', function () {
            const username = usernameInput.value.trim(); // Get the value from the input field

            // Check if the username length is at least 3 characters
            if (username.length < 3) {
                // Show the warning message if less than 3 characters
                warningMessage.classList.remove('d-none');
                feedbackAvailable.classList.add('d-none');
                feedbackTaken.classList.add('d-none');
            } else {
                // Hide the warning message when the username length is valid
                warningMessage.classList.add('d-none');

                // Make an AJAX request to check the username
                fetch('{{ route('admin.users.checkUsername') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ username: username }), // Send the username to the server
                })
                .then(response => response.json())
                .then(data => {
                    // Display feedback based on the availability
                    if (data.available) {
                        feedbackTaken.classList.add('d-none'); // Hide taken message
                        feedbackAvailable.classList.remove('d-none'); // Show available message
                    } else {
                        feedbackAvailable.classList.add('d-none'); // Hide available message
                        feedbackTaken.classList.remove('d-none'); // Show taken message
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    feedbackAvailable.classList.add('d-none');
                    feedbackTaken.classList.add('d-none');
                });
            }
        });
    }
});

</script>

<script>
    // Function to update the Try Now button's URL with the entered username
    function updateTryNowButton() {
        // Get the username from the input field
        const username = document.getElementById('usernameInput').value;

        // Get the Try Now button
        const tryNowButton = document.getElementById('tryNowButton');

        // If username exists, append it to the register page URL
        if (username) {
            const url = new URL(tryNowButton.href);
            url.searchParams.set('username', username);  // Add username as a query parameter
            tryNowButton.href = url.toString(); // Update the href of the button
        }
    }

    document.getElementById('tryNowButton').addEventListener('click', function(event) {
        // Prevent the default behavior of the link if no username is entered
        const username = document.getElementById('usernameInput').value;
        if (!username) {
            event.preventDefault(); // Don't navigate if no username is entered
            alert("Please enter a username.");
        }
    });
</script>