<ul class="navbar-nav">
    @foreach ($navMenus as $navMenu)
        @php
            if (!filter_var($navMenu->link, FILTER_VALIDATE_URL)) {
                $navMenu->link = url("/").$navMenu->link;
            }
        @endphp
        @if ($navMenu->children->count() > 0)
            <li class="nav-item">
                <a href="{{ $navMenu->link }}" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    {{ $navMenu->name }}
                </a>
                <ul class="dropdown-menu">
                    @foreach ($navMenu->children as $child)
                        @php
                            if (!filter_var($child->link, FILTER_VALIDATE_URL)) {
                                $child->link = url("/").$child->link;
                            }
                        @endphp
                        <li class="nav-item">
                            <a href="{{ $child->link }}" class="nav-link">{{ $child->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li class="nav-item">
                <a href="{{ $navMenu->link }}" class="nav-link">
                    {{ $navMenu->name }}
                </a>
            </li>
        @endif
    @endforeach

    @guest

    <!--/ # When user logout or new user login signup button-->
        <li class="nav-item d-block d-sm-none">
            <a href="{{ route('login') }}" class="nav-link">
                {{ ___('Log in') }}
            </a>
        </li>
        @if ($settings->enable_user_registration)
            <li class="nav-item d-block d-sm-none">
                <a href="{{ route('register') }}" class="nav-link">
                    {{ ___('Sign up') }}
                </a>
            </li>
            <!--/ # When user logout or new user login signup button-->
        @endif
    @endguest
</ul>
