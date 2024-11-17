<div class="nav-others d-flex align-items-center">
    <!--/ # Change language button-->
    <ul class="navbar-nav">
        <li class="nav-item">
            @php
                $language = current_language();
            @endphp
            <a title="{{ $language->name }}" href="#" class="nav-link dropdown-toggle d-flex align-items-center">
                <img src="{{ asset('storage/flags/' . $language->flag) }}" title="{{ $language->name }}"
                     alt="{{ $language->name }}" width="16" height="11">
                <span class="ml-5 d-none d-sm-block">{{ $language->name }}</span>
            </a>
            <ul class="dropdown-menu w-auto">
                @foreach ($languages as $language)
                    <li class="nav-item">
                        <a title="English" href="{{ lang_url($language->code) }}"
                           class="nav-link @if ($language->code == get_lang()) active @endif">
                            <img src="{{ asset('storage/flags/'.$language->flag) }}" alt="{{ $language->name }}"
                                 title="{{ $language->name }}" width="16" height="11">
                            <span class="ml-5">{{ $language->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>
    <!--/ # Change language button-->
@auth
    <!--/ # When user login user profile image with button-->
        <div class="dropdown ml-16 ">
            <button class="button icon-group -secondary dropdown-toggle size-45" type="button"
                    data-bs-toggle="dropdown">
                <img src="{{ asset('storage/users/'.request()->user()->avatar) }}" alt="{{ request()->user()->name }}"
                     class="rounded-circle">
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                @if(request()->user()->user_type == 'admin')
                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}" target="_blank"><i
                                class="fa-regular fa-user-tie-hair mr-5"></i> {{ ___('Admin') }}</a></li>
                    <div class="dropdown-divider"></div>
                @endif
                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i
                            class="fa-regular fa-home mr-5"></i> {{ ___('Dashboard') }}</a></li>
                <li><a class="dropdown-item" href="{{ route('subscription') }}"><i
                            class="fa-regular fa-gift mr-5"></i> {{ ___('Membership') }}</a></li>
                <li><a class="dropdown-item" href="{{ route('transactions') }}"><i
                            class="fa-regular fa-file-alt mr-5"></i> {{ ___('Transactions') }}</a></li>
                <div class="dropdown-divider"></div>
                <li><a class="dropdown-item" href="{{ route('settings') }}"><i
                            class="fa-regular fa-cog mr-5"></i> {{ ___('Settings') }}</a></li>
                <li><a class="dropdown-item" href="#"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="fa-regular fa-right-from-bracket mr-5"></i> {{ ___('Logout') }}</a></li>
            </ul>
        </div>
        <form id="logout-form" class="d-inline" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
        <!--/ # When user login user profile image with button-->
@endauth
@guest

    <!--/ # When user logout or new user login signup button-->
        <div class="d-flex justify-content-center d-none d-md-flex">
            <a href="{{ route('login') }}"
               class="ml-16 button -secondary text-dark-1 px-15 rounded-pill fw-semibold font-16">{{ ___('Log in') }}
            </a>
            @if ($settings->enable_user_registration)
                <a href="{{ route('register') }}"
                   class="ml-16 button bg-primary text-white px-15 rounded-pill fw-semibold font-16">{{ ___('Sign up') }}
                </a>
            @endif
        </div>
        <!--/ # When user logout or new user login signup button-->

@endguest

<!--/ # On responsive hamburger menu button for offcanvas desktop nav-->
    <div class="sidemenu-header ml-16 d-lg-none">
        <div class="responsive-burger-menu icon-group -secondary" data-bs-toggle="offcanvas"
             data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <i class="fa-solid fa-bars-staggered"></i>
        </div>
    </div>
    <!--/ # On responsive hamburger menu button for offcanvas desktop nav-->
</div>
