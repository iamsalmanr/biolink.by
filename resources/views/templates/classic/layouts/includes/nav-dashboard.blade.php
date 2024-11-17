<div class="desktop-nav">
    <nav class="navbar navbar-expand-md navbar-light">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img class="white-logo" src="{{ asset('storage/brand/'.$settings->media->light_logo) }}" alt="{{ @$settings->site_title }}" />
            <img class="main-logo" src="{{ asset('storage/brand/'.$settings->media->dark_logo) }}" alt="{{ @$settings->site_title }}" />
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @include($activeTheme.'layouts.includes.nav-menu')
        </div>
        @include($activeTheme.'layouts.includes.nav-rightarea')
    </nav>
</div>
