@extends($activeTheme.'layouts.main')
@section('title', ___('Checkout'))
@section('content')
    <section class="page-banner-area theme-gradient-3 pt-170">
        <div class="container">
            <div class="row wow fadeInUp" data-wow-delay="300ms">
                <div class="col-md-10 col-xl-8 mx-auto">
                    <div class="d-flex flex-column align-items-center">
                        <h2>{{ ___('Checkout')  }}</h2>
                        <p>{{ ___('Experience the joy of hassle-free payments.')  }}</p>
                        <ol class="breadcrumb text-grey-2">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ ___('Home') }}</a></li>
                            <li class="breadcrumb-item active text-dark-1"
                                aria-current="page">{{ ___('Checkout')  }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-subscription pt-70 pb-100">
        <div class="container">

            <!-- / Coupon Code-->
            <div class="row wow fadeIn">
                <div class="col-12">
                    @if (is_numeric($plan->id))
                        @if (!$coupon)
                            <div class="coupon-toggle">
                                <div id="accordion" class="accordion">
                                    <div class="card pb-0">
                                        <div class="card-header pb-30" id="headingOne">
                                            <div class="card-title mb-0">
                                                <span><i class="fa fa-window-maximize"></i> {{ ___('Have a coupon?') }}</span>
                                                <button
                                                    class="accordion-toggle collapsed text-decoration -underline-2 ml-8"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                    aria-expanded="false"
                                                    aria-controls="collapseOne">{{ ___('Click here to enter your code') }}
                                                </button>
                                            </div>
                                        </div>
                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                             data-bs-parent="#accordion">
                                            <div class="card-body border-top pt-20 pb-30">
                                                <p>{{ ___('If you have a coupon code, please apply it below.') }}</p>
                                                <div class="coupon-code-input w-50">
                                                    <form
                                                        action="{{ request()->fullUrl() }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="input-group">
                                                            <input type="text" name="coupon_code"
                                                                   class="form-control text-field"
                                                                   placeholder="{{ ___('Enter coupon code') }}"
                                                                   value="{{ old('coupon_code') }}" required>
                                                            <button type="submit"
                                                                    class="button -primary transform-none h-48-px">{{ ___('Apply') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div
                                class="d-flex justify-content-between align-items-center alert alert-primary mb-0 py-2">
                                <span>
                                    <i class="fa-solid fa-ticket me-2"></i> {{ ___('Coupon code') }} <span
                                        class="fw-bold">{{ $coupon->code }}</span> {{ ___('Applied') }}.
                                </span>
                                <a href=""><i class="fa fa-times"></i> {{ ___('Remove Coupon') }}</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <!-- / Coupon Code-->

            <div class="row wow fadeInUp">
                <h4 class="my-30">{{ ___('Checkout') }}</h4>

                <div class="col-12 col-md-7 col-lg-8">
                    <form action="{{ request()->fullUrl() }}"
                          method="POST">
                        @csrf
                        @if($coupon)
                            <input type="hidden" name="coupon_code" value="{{ $coupon->code }}">
                        @endif
                    <!-- / Billing address-->
                        <div class="card">
                            <div class="billing-address">
                                <h4 class="mb-28">{{ ___('Billing address') }}</h4>
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col">
                                        <label class="form-label">{{ ___('First Name') }} : </label>
                                        <input type="text" class="form-control form-control-md"
                                               placeholder="{{ ___('First Name') }}" value="{{ $user->firstname }}"
                                               disabled>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">{{ ___('Last Name') }} : </label>
                                        <input type="text" class="form-control form-control-md"
                                               placeholder="{{ ___('Last Name') }}" value="{{ $user->lastname }}"
                                               disabled>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ ___('Address') }} : <span
                                            class="required">*</span></label>
                                    <input type="text" name="address" class="form-control form-control-md"
                                           value="{{ @$user->address->address }}" required>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">{{ ___('City') }} : <span
                                                    class="required">*</span></label>
                                            <input type="text" name="city" class="form-control form-control-md"
                                                   value="{{ @$user->address->city }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">{{ ___('State') }} : <span
                                                    class="required">*</span></label>
                                            <input type="text" name="state" class="form-control form-control-md"
                                                   value="{{ @$user->address->state }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">{{ ___('Postal code') }} : <span
                                                    class="required">*</span></label>
                                            <input type="text" name="zip" class="form-control form-control-md"
                                                   value="{{ @$user->address->zip }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">{{ ___('Country') }} : <span
                                            class="required">*</span></label>
                                    <select name="country" class="form-select form-select-md" required>
                                        @foreach (countries() as $country)
                                            <option value="{{ $country->id }}"
                                                {{ $country->name == @$user->address->country ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- / Billing address-->
                        @if ($total > 0)
                        <!-- / Payment Methods-->
                            <div class="card">
                                <div class="payment-method">
                                    <h4 class="mb-28">{{ ___('Payment Methods') }}</h4>

                                    @forelse ($paymentGateways as $paymentGateway)
                                        <div class="method-type mb-16">
                                            <div data-bs-toggle="collapse" data-bs-target="#{{ $paymentGateway->key }}"
                                                 aria-expanded="false" aria-controls="{{ $paymentGateway->key }}"
                                                 class="d-flex flex-wrap">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                           id="{{ $paymentGateway->key }}"
                                                           value="{{ $paymentGateway->id }}"
                                                        {{ $loop->first ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                           for="{{ $paymentGateway->key }}">{{ $paymentGateway->name }}</label>
                                                </div>
                                                <img class="h-30-px ml-auto"
                                                     src="{{ asset('storage/payments/'.$paymentGateway->logo) }}"
                                                     alt="{{ $paymentGateway->name }}">
                                            </div>
                                            <div class="collapse" id="{{ $paymentGateway->key }}">
                                                <div class="card-inner-wrapper mt-16">
                                                    {{ ___('You will be redirected to the payment page for complete payment.') }}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info mb-0">
                                            {{ ___('No payment methods available right now please try again later.') }}
                                        </div>
                                    @endforelse

                                </div>
                            </div>
                            <!-- / Payment Methods-->
                            <button type="submit" name="payment_submit"
                                    class="button -primary -lg transform-none px-20 push-right mb-40 mt-15">{{ ___('Pay Now') }}
                                <i class="fa-regular fa-arrow-right-long ml-5 push-this"></i></button>

                        @else
                            <button type="submit" name="payment_submit"
                                    class="button -primary -lg transform-none px-20 push-right mb-40 mt-15">{{ ___('Continue') }}
                                <i class="fa-regular fa-arrow-right-long ml-5 push-this"></i></button>
                        @endif
                    </form>
                </div>
                <!-- / Order Box-->
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="card">
                        <div class="order-summary-widget">
                            <h4 class="mb-28">{{ ___('Order Summary') }}</h4>
                            <div class="d-flex justify-content-between align-items-center mb-8">
                                <span>{{ ___('Plan') }}</span>
                                <span class="text-dark fw-semibold">
                                    {{ $plan->name }}
                                    @if($interval)
                                        <span
                                            class="text-muted text-capitalize">({{plan_interval_text($interval)}})</span>
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-8">
                                <span>{{ ___('Start Date') }}</span>
                                <span class="text-dark">
                                    {{ $planStartDate }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-8">
                                <span>{{ ___('End Date') }}</span>
                                <span class="text-dark">
                                    {{ $planEndDate }}
                                </span>
                            </div>
                            <div class="separator-1px-op-l my-20"></div>
                            <div class="d-flex justify-content-between align-items-center mb-8">
                                <span>{{ ___('Plan Fee') }}</span>
                                <span class="text-dark fw-semibold">
                                    {{ price_symbol_format($price) }}
                                </span>
                            </div>
                            @if ($coupon)
                                <div class="d-flex justify-content-between align-items-center mb-8">
                                        <span class="text-success">
                                            {{ ___('Discount') }} ({{ $coupon->percentage }}%)
                                        </span>
                                    <span class="text-dark fw-semibold">
                                            -{{ price_symbol_format($price - $price_after_discount) }}
                                        </span>
                                </div>
                                <div class="total d-flex justify-content-between align-items-center mb-8">
                                    <span>{{ ___('Subtotal') }}</span>
                                    <span
                                        class="text-dark fw-semibold">{{ price_symbol_format($price_after_discount) }}</span>
                                </div>
                            @endif
                            @if ($tax)
                                <div class="d-flex justify-content-between align-items-center mb-8">
                                    <span>{{ ___('Tax'). ' ('.$tax->percentage.'%)' }}</span>
                                    <span class="text-dark fw-semibold">
                                        @if ($coupon)
                                            +{{ price_symbol_format($tax_after_discount) }}
                                        @else
                                            +{{ price_symbol_format($calculated_tax) }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                            <div class="separator-1px-op-l my-20"></div>
                            <div class="total d-flex justify-content-between align-items-center h6 mb-8 text-primary">
                                <span class="mb-0 h5">{{ ___('Total') }}</span>
                                <span class="mb-0 h5">{{ price_code_format($total) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Order Box-->
            </div>
        </div>
    </section>
@endsection
