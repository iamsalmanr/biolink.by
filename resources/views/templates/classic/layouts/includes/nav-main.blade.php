
<div class="desktop-nav">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img class="white-logo" src="{{ asset('storage/brand/'.$settings->media->light_logo) }}" alt="{{ @$settings->site_title }}" />
            <img class="main-logo" src="{{ asset('storage/brand/'.$settings->media->dark_logo) }}" alt="{{ @$settings->site_title }}" />
        </a>
        <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start" tabindex="-1" id="offcanvasExample"
             aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header d-lg-none">
                <h3 class="navbar-brand offcanvas-title mb-0 font-24" id="offcanvasExampleLabel">
                    <img class="white-logo" src="{{ asset('storage/brand/'.$settings->media->light_logo) }}" alt="{{ @$settings->site_title }}" />
                    <img class="main-logo" src="{{ asset('storage/brand/'.$settings->media->dark_logo) }}" alt="{{ @$settings->site_title }}" />
                </h3>
                <button type="button" class="icon-group -secondary" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="offcanvas-body me-auto d-flex flex-column h-100">
                @include($activeTheme.'layouts.includes.nav-menu')
            </div>
        </div>
        @include($activeTheme.'layouts.includes.nav-rightarea')
    </nav>
</div>
