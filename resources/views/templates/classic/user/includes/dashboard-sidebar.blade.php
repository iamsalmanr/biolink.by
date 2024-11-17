<div class="sidemenu-area">
    <div class="sidemenu-header">
        <div class="responsive-burger-menu d-block">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
    <div class="sidemenu-body">
        <ul class="sidemenu-nav h-100" id="sidemenu-nav" data-simplebar>
            <li class="nav-item  {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <span class="icon"><i class="fa-regular fa-house"></i></span>
                    <span class="menu-title">{{ ___('Dashboard') }}</span>
                </a>
            </li>
            <li class="pl-24 pt-24 font-12 mb-5 text-uppercase text-grey-1">{{ ___('Organize and Manage') }}</li>
            <li class="nav-item {{ request()->routeIs('subscription') ? 'active' : '' }}">
                <a href="{{ route('subscription') }}" class="nav-link">
                    <span class="icon"><i class="fa-regular fa-gift"></i></span>
                    <span class="menu-title">{{ ___('Membership') }}</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('transactions') ? 'active' : '' }}">
                <a href="{{ route('transactions') }}" class="nav-link">
                    <span class="icon"><i class="fa-regular fa-file-alt"></i></span>
                    <span class="menu-title">{{ ___('Transactions') }}</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">
                <a href="{{ route('settings') }}" class="nav-link">
                    <span class="icon"><i class="fa-regular fa-cog"></i></span>
                    <span class="menu-title">{{ ___('Settings') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="icon"><i class="fa-regular fa-sign-out"></i></span>
                    <span class="menu-title">{{ ___('Logout') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<form id="logout-form" class="d-inline" action="{{ route('logout') }}" method="POST">
    @csrf
</form>
