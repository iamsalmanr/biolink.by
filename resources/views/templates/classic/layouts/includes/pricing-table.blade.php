@if($plan->status == 1)
    <div class="col-md-4 md-mb-16 pricing-plan {{ @$plan->recommended ? 'popular' : '' }}"
         data-monthly-price="{{ @$plan->monthly_price }}"
         data-annual-price="{{ @$plan->annual_price }}"
         data-lifetime-price="{{ @$plan->lifetime_price }}">
        <div class="card-inner-wrapper pricing">
            <div class="text-center">
                <div class="pricing-table-headline mt-16">
                    <h3 class="title font-18 fw-bold mb-0">
                        {{ !empty($plan->translations->{get_lang()}->name)
                            ? $plan->translations->{get_lang()}->name
                            : $plan->name }}
                    </h3>
                    <p class="subtitle">
                        {{ !empty($plan->translations->{get_lang()}->description)
                            ? $plan->translations->{get_lang()}->description
                            : $plan->description }}
                    </p>
                </div>
                <div class="pricing-table-price mt-16 mb-16">
                    @if ($plan->id == 'free')
                        <span class="price-number">{{ ___('Free') }}</span>
                    @elseif($plan->id == 'trial')
                        <span class="price-number">{{ ___('Trial') }}</span>
                    @else
                        <span class="pricing-plan-label billed-monthly-label">
                        <span
                            class="price-number">{{ price_symbol_format($plan->monthly_price) }}</span>
                        <span class="badge text-capitalize">{{ ___('Monthly') }}</span>
                    </span>
                        <span class="pricing-plan-label billed-yearly-label">
                        <span
                            class="price-number">{{ price_symbol_format($plan->annual_price) }}</span>
                        <span class="badge text-capitalize">{{ ___('Yearly') }}</span>
                    </span>
                        <span class="pricing-plan-label billed-lifetime-label">
                        <span
                            class="price-number">{{ price_symbol_format($plan->lifetime_price) }}</span>
                        <span class="badge text-capitalize">{{ ___('Lifetime') }}</span>
                    </span>
                    @endif
                </div>
            </div>
            <div
                class="pricing-table-details mb-16">{{ ___('Get the following deal without any risk and fees.') }}</div>
            <div class="pricing-table-features">
                <ul class="list-unstyled">
                    <li class="exist">
                        <i class="fa-regular fa-check mr-10 text-success"></i>
                        <span>{!! ___('Bio pages limit :bio_pages_limit', ['bio_pages_limit' => '<strong>' . ($plan->settings->biopage_limit == -1 ? ___('Unlimited') : number_format($plan->settings->biopage_limit)) . '</strong>']) !!}</span>
                    </li>
                    <li class="exist">
                        <i class="fa-regular fa-check mr-10 text-success"></i>
                        <span>{!! ___('Add link limit :bio_link_limit', ['bio_link_limit' => '<strong>' . ($plan->settings->biolink_limit == -1 ? ___('Unlimited') : number_format($plan->settings->biolink_limit)) . '</strong>']) !!}</span>
                        <i class="fa-regular fa-info-circle" data-bs-toggle="tooltip"
                           title="{{ ___('Per Bio link pages') }}"></i>
                    </li>
                    <li class="exist">
                        @if ($plan->settings->hide_branding)
                            <i class="fa-regular fa-check mr-10 text-success"></i>
                        @else
                            <i class="fa-regular fa-close mr-10 text-danger"></i>
                        @endif
                        <span>{{ ___('Hide branding') }}</span>
                        <i class="fa-regular fa-info-circle" data-bs-toggle="tooltip"
                           title="{{ ___('Ability to remove the branding from the Bio link pages') }}"></i>
                    </li>

                    @if (!$plan->settings->advertisements)
                        <li class="exist">
                            <i class="fa-regular fa-check mr-10"></i>
                            <span>{{ ___('No Advertisements') }}</span>
                        </li>
                    @endif
                    @if ($plan->settings->custom_features)
                        @foreach ($plan->settings->custom_features as $key => $value)
                            @php $planoption = plan_option($key) @endphp
                            @if($planoption)
                                <li class="exist">
                                    @if ($value == 1)
                                        <i class="fa-regular fa-check mr-10 text-success"></i>
                                    @else
                                        <i class="fa-regular fa-close mr-10 text-danger"></i>
                                    @endif

                                    <span>
                                {{ !empty($planoption->translations->{get_lang()}->title)
                                ? $planoption->translations->{get_lang()}->title
                                : $planoption->title }}
                            </span>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
            @if(auth()->check() && request()->user()->plan_id == $plan->id)
                <button type="button"
                        class="button {{ @$plan->recommended ? '-primary' : 'bg-dark-1'}} text-white -lg w-100 mt-16 transform-none"
                        disabled>{{___('Current Plan')}}</button>
            @else
                <button type="submit" name="plan" value="{{ $plan->id }}"
                        class="button {{ @$plan->recommended ? '-primary' : 'bg-dark-1'}} text-white -lg w-100 mt-16">{{___('Choose Plan')}}</button>
            @endif
        </div>
    </div>
@endif
