<!-- /# App Footer-->
<div class="flex-wrap d-flex align-items-center justify-content-center justify-content-sm-between font-16 mt-50 gap-3">
    <div class="text-center text-sm-start">
        &copy; <span>{{date("Y")}}</span>
            {{ @$settings->site_title }} - {{ ___('All rights reserved') }}
    </div>
    <div class="d-flex gap-3">
        @if (@$settings->terms_of_service_link)
                <a href="{{ @$settings->terms_of_service_link }}" class="text-dark-1 text-decoration -underline">{{ ___('Term & Condition') }}</a>
        @endif

        @if (@$settings->enable_contact_page)
                <a href="{{ route('contact') }}" class="text-dark-1 text-decoration -underline">{{ ___('Contact') }}</a>

        @endif
    </div>
</div>

<!-- /# App Footer-->
