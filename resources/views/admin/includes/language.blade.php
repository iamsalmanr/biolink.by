<div class="dropdown d-inline-block">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-globe me-2"></i>{{ strtoupper($current_language) }}
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        @foreach ($admin_languages as $adminLanguage)
            <li><a class="dropdown-item @if ($adminLanguage->code == $current_language) active @endif"
                   href="?lang={{ $adminLanguage->code }}">{{ $adminLanguage->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
