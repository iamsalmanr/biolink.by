<div class="desktop-nav">
    <nav class="navbar navbar-expand-md navbar-light">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img class="white-logo" src="{{ asset('storage/brand/logo_dark_main.svg') }}" alt="{{ @$settings->site_title }}" />
            <img class="main-logo" src="{{ asset('storage/brand/logo_light_main.svg') }}" alt="{{ @$settings->site_title }}" />
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @include($activeTheme.'layouts.includes.nav-menu')
        </div>
        @include($activeTheme.'layouts.includes.nav-rightarea')
    </nav>
</div>
