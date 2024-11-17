@extends($activeTheme.'layouts.main')
@section('title', ___('Pricing'))
@section('content')
    <section class="page-banner-area theme-gradient-3 pt-170 @if (ads('home_page_top')) mb-40 @else mb-70 @endif ">
        <div class="container">
            <div class="row wow fadeInUp" data-wow-delay="300ms">
                <div class="col-md-10 col-xl-8 mx-auto">
                    <div class="d-flex flex-column align-items-center">
                        <h2>{{ ___('Pricing') }}</h2>
                        <ol class="breadcrumb text-grey-2">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ ___('Home') }}</a></li>
                            <li class="breadcrumb-item active text-dark-1" aria-current="page">{{ ___('Pricing') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! ads_on_home_top() !!}
    <section class="our-pricing pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                    <div class="main-title text-center">
                        <h2 class="title">{{ ___('Membership Plans') }}</h2>
                        <p class="paragraph mt10">{{ ___('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce leo nibh, varius vitae augue quis, pulvinar gravida justo. Suspendisse quis est consectetur, placerat justo feugiat, maximus leo pricing.') }}</p>
                    </div>
                </div>
            </div>
            <div class="pricing-table wrapper">
                <form action="{{route('checkout.index')}}" method="get">

                <div class="billing-cycle-radios">
                    @if($total_monthly)
                        <div class="form-check form-check-inline billed-monthly-radio">
                            <input class="form-check-input" type="radio" name="interval"
                                   id="radio-monthly"
                                   value="monthly" checked>
                            <label class="form-check-label text-capitalize"
                                   for="radio-monthly">{{___('Monthly')}}</label>
                        </div>
                    @endif
                    @if($total_annual)
                        <div class="form-check form-check-inline billed-yearly-radio">
                            <input class="form-check-input" type="radio" name="interval"
                                   id="radio-yearly"
                                   value="yearly" checked>
                            <label class="form-check-label text-capitalize"
                                   for="radio-yearly">{{___('Yearly')}}</label>
                        </div>
                    @endif
                    @if($total_lifetime)
                        <div class="form-check form-check-inline billed-lifetime-radio">
                            <input class="form-check-input" type="radio" name="interval"
                                   id="radio-lifetime"
                                   value="lifetime" checked>
                            <label class="form-check-label text-capitalize"
                                   for="radio-lifetime">{{___('Lifetime')}}</label>
                        </div>
                    @endif
                </div>

                <div class="plans">
                    <div class="plans-item">
                        <div class="pricing-table row gx-2 gy-5 mt-2 wow fadeIn">

                            @foreach ([$free_plan, $trial_plan] as $plan)
                                @include($activeTheme.'layouts.includes.pricing-table')
                            @endforeach

                            @foreach ($plans as $plan)
                                @include($activeTheme.'layouts.includes.pricing-table')
                            @endforeach
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>


    {!! ads_on_home_bottom() !!}
@endsection
