@extends($activeTheme.'layouts.main')
@section('title', ___('Contact Us'))
@section('content')
    <section class="page-banner-area theme-gradient-3 pt-170 @if (ads('home_page_top')) mb-40 @else mb-70 @endif">
        <div class="container">
            <div class="row wow fadeInUp" data-wow-delay="300ms">
                <div class="col-md-10 col-xl-8 mx-auto">
                    <div class="d-flex flex-column align-items-center">
                        <h2>{{ ___('Contact Us') }}</h2>
                        <p>{{ ___("We'd love to talk about how we can help you.") }}</p>
                        <ol class="breadcrumb text-grey-2">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ ___('Home') }}</a></li>
                            <li class="breadcrumb-item active text-dark-1" aria-current="page">{{ ___('Contact Us') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! ads_on_home_top() !!}
    <section class="our-contact-form pb-100">
        <div class="container">
            <div class="row wow fadeInUp">
                <div class="col-xl-8 offset-xl-2">
                    <div class="card">
                        <form action="{{ route('contact') }}" method="POST">
                            @csrf
                            <div class="row row-cols-1 g-3 row-cols-md-2 gx-3 mb-3">
                                <div class="col">
                                    <label class="form-label">{{ ___('Name') }} : <span class="required text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control text-field form-control-md" value="{{ request()->user()->name ?? old('name') }}" required="">
                                </div>
                                <div class="col">
                                    <label class="form-label">{{ ___('Email address') }} : <span class="required text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control text-field form-control-md" value="{{ request()->user()->email ?? old('email') }}" required="">
                                </div>
                            </div>
                            <div class="mb-16">
                                <label class="form-label">{{ ___('Subject') }} : <span class="required text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control text-field form-control-md" value="{{ old('subject') }}" required="">
                            </div>
                            <div class="mb-16">
                                <label class="form-label">{{ ___('Message') }} : <span class="required text-danger">*</span></label>
                                <textarea name="message" class="form-control text-field" rows="6" placeholder="{{ ___('Enter your message here') }}..." spellcheck="false">{{ old('message') }}</textarea>
                            </div>
                            {!! display_captcha() !!}
                            <button class="button bg-primary-l text-primary transform-none rounded-2 px-20 push-right">{{ ___('Submit') }} <i class="fa-regular fa-arrow-right-long ml-5 push-this"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {!! ads_on_home_bottom() !!}
    @push('scripts_at_bottom')
        {!! google_captcha() !!}
    @endpush
@endsection
