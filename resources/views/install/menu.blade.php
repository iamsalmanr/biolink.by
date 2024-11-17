@php
    $menu = [
        [
            'icon' => 'home',
            'route' => 'install'
        ],
        [
            'icon' => 'list',
            'route' => 'install.requirements'
        ],
        [
            'icon' => 'folder-open',
            'route' => 'install.permissions'
        ],
        [
            'icon' => 'server',
            'route' => 'install.database'
        ],
        [
            'icon' => 'user-circle',
            'route' => 'install.admin'
        ],
        [
            'icon' => 'check',
            'route' => 'install.complete'
        ]
    ];
@endphp

<div class="nav flex-column">
    <ul class="nav nav-pills d-flex justify-content-center mb-4">
        @foreach ($menu as $link)
            <li class="nav-item mx-1">
                @if(Route::currentRouteName() == $link['route'])
                    <a href="{{ route($link['route']) }}" class="btn btn-primary d-flex align-items-center">
                        <i class="far fa-{{$link['icon']}}"></i>
                    </a>
                @else
                    <a href="{{ route($link['route']) }}" class="btn d-flex align-items-center disabled">
                        <i class="far fa-{{$link['icon']}}"></i>
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</div>
