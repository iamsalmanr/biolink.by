@extends($activeTheme.'layouts.main')
@section('title', $page->title)
@section('description', $page->short_description)
@section('content')
    <section class="page-banner-area theme-gradient-3 pt-170 @if (ads('home_page_top')) mb-40 @else mb-70 @endif">
        <div class="container">
            <div class="row wow fadeInUp" data-wow-delay="300ms">
                <div class="col-md-10 col-xl-8 mx-auto">
                    <div class="d-flex flex-column align-items-center">
                        <h2>{{ $page->title }}</h2>
                        <ol class="breadcrumb text-grey-2">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ ___('Home') }}</a></li>
                            <li class="breadcrumb-item active text-dark-1" aria-current="page">{{ $page->title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! ads_on_home_top() !!}
    <section class="our-feature-request pb-100">
        <div class="container">
            <div class="row wow fadeInUp">
                <div class="col-xl-8 offset-xl-2">
                    <div class="card">
                        <div class="term-content">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! ads_on_home_bottom() !!}
@endsection
