<!-- footer area start -->
<footer>
    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            <div class="d-flex flex-column align-items-center">
                <img class="mb-16 w-110-px" src="{{ asset('storage/brand/'.$settings->media->dark_logo) }}" alt="{{ @$settings->site_title }}">
                <div class="d-flex align-items-center font-16 gap-3">
                    @if ($navMenus->count() > 0)
                        @foreach ($navMenus as $navMenu)
                            @php
                                if (!filter_var($navMenu->link, FILTER_VALIDATE_URL)) {
                                    $navMenu->link = url("/").$navMenu->link;
                                }
                            @endphp
                            <div class="">
                                <a href="{{ $navMenu->link }}" class="-underline fw-semibold">{{ $navMenu->name }}</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="separator-1px-op-l my-32"></div>
        <div class="row align-items-center g-4 g-md-0 pb-32">
            <div class="col-md-4 order-md-first order-last text-md-start text-center">
                © {{date('Y')}} {{ @$settings->site_title }} {{ ___('All rights reserved') }}
            </div>
            <div class="col-md-4">
                <div class="d-flex font-16 gap-3 justify-content-center">
                    @if (@$settings->terms_of_service_link)
                        <div>
                            <a href="{{ @$settings->terms_of_service_link }}" class="text-dark-1 text-decoration -underline fw-semibold">{{ ___('Term & Condition') }}</a>
                        </div>
                    @endif

                    @if (@$settings->enable_contact_page)
                        <div>
                            <a href="{{ route('contact') }}" class="text-dark-1 text-decoration -underline fw-semibold">{{ ___('Contact') }}</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex font-16 gap-3 justify-content-md-end justify-content-center">
                    @if (@$settings->social_links->facebook)
                        <div>
                            <a href="{{@$settings->social_links->facebook}}" class="icon-group -outlined -light shadow-3 rounded-3"><i class="fa-brands fa-facebook"></i></a>
                        </div>
                    @endif
                    @if (@$settings->social_links->twitter)
                        <div>
                            <a href="{{@$settings->social_links->twitter}}" class="icon-group -outlined -light shadow-3 rounded-3"><i class="fa-brands fa-twitter"></i></a>
                        </div>
                    @endif
                    @if (@$settings->social_links->instagram)
                        <div>
                            <a href="{{@$settings->social_links->instagram}}" class="icon-group -outlined -light shadow-3 rounded-3"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    @endif
                    @if (@$settings->social_links->linkedin)
                        <div>
                            <a href="{{@$settings->social_links->linkedin}}" class="icon-group -outlined -light shadow-3 rounded-3"><i class="fa-brands fa-linkedin"></i></a>
                        </div>
                    @endif
                    @if (@$settings->social_links->pinterest)
                        <div>
                            <a href="{{@$settings->social_links->pinterest}}" class="icon-group -outlined -light shadow-3 rounded-3"><i class="fa-brands fa-pinterest"></i></a>
                        </div>
                    @endif
                    @if (@$settings->social_links->youtube)
                        <div>
                            <a href="{{@$settings->social_links->youtube}}" class="icon-group -outlined -light shadow-3 rounded-3"><i class="fa-brands fa-youtube"></i></a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer area end -->

