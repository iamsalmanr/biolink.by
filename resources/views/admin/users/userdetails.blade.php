<div class="quick-card card">
    <div class="card-body">
        <div class="user-avatar-section mb-2">
            <div class="d-flex align-items-center flex-column">
                <img id="filePreview" class="img-fluid rounded my-3"
                     src="{{ asset('storage/users/'.$user->avatar) }}" height="110" width="110"
                     alt="User avatar">
                <div class="user-info text-center mt-2">
                    <h4 class="mb-2">{{ $user->name }}</h4>
                </div>
            </div>
        </div>
    </div>
    <ul class="custom-list-group list-group list-group-flush border-top">
        <li class="list-group-item d-flex justify-content-between"><span>{{ ___('Username') }} :</span>
            <strong>{{ $user->username }}</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between"><span>{{ ___('Email') }} :</span>
            <strong>{{ $user->email }}</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between"><span>{{ ___('Status') }} :</span>
            @if ($user->status)
                <span class="badge bg-success">{{___('Active')}}</span>
            @else
                <span class="badge bg-danger">{{___('Banned')}}</span>
            @endif
        </li>
        <li class="list-group-item d-flex justify-content-between"><span>{{ ___('Email Verify') }} :</span>
            @if ($user->email_verified_at)
                <span class="badge bg-success">{{___('Verified')}}</span>
            @else
                <span class="badge bg-warning">{{___('Unverified')}}</span>
            @endif
        </li>
        <li class="list-group-item d-flex justify-content-between"><span>{{ ___('Joined at') }} :</span>
            <strong>{{ datetime_formating($user->created_at) }}</strong>
        </li>
    </ul>
</div>

<div class="quick-card card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">{{$user->plan()->name}}</h4>
            @if($user->plan_interval)
                <span class="badge bg-primary">{{plan_interval_text($user->plan_interval)}}</span>
            @endif
        </div>
        <ul class="mb-0 list-unstyled">
            <li class="mb-2">
                <i class="fa-regular fa-check mr-10 text-success"></i>
                <span>{!! ___('Bio pages limit :bio_pages_limit', ['bio_pages_limit' => '<strong>' . number_format($user->plan_settings->biopage_limit) . '</strong>']) !!}</span>
            </li>
            <li class="mb-2">
                <i class="fa-regular fa-check mr-10 text-success"></i>
                <span>{!! ___('Add link limit :bio_link_limit', ['bio_link_limit' => '<strong>' . number_format($user->plan_settings->biolink_limit) . '</strong>']) !!}</span>
                <i class="fa-regular fa-info-circle" data-tippy-placement="top"
                   title="{{ ___('Per Bio link pages') }}"></i>
            </li>
            <li class="mb-2">
                @if ($user->plan_settings->hide_branding)
                    <i class="fa-regular fa-check mr-10 text-success"></i>
                @else
                    <i class="fa-regular fa-close mr-10 text-danger"></i>
                @endif
                <span>{{ ___('Hide branding') }}</span>
                <i class="fa-regular fa-info-circle" data-tippy-placement="top"
                   title="{{ ___('Ability to remove the branding from the Bio link pages') }}"></i>
            </li>
            @if (!$user->plan_settings->advertisements)
                <li class="mb-2">
                    <i class="fa-regular fa-check mr-10"></i>
                    <span>{{ ___('No Advertisements') }}</span>
                </li>
            @endif
            @if(!empty($user->plan_settings->custom_features))
                @foreach ($user->plan_settings->custom_features as $key => $value)
                    @php $planoption = plan_option($key) @endphp
                    @if($planoption)
                        <li class="mb-2">
                            @if ($value == 1)
                                <i class="fa-regular fa-check mr-10 text-success"></i>
                            @else
                                <i class="fa-regular fa-close mr-10 text-danger"></i>
                            @endif
                            <span>{{ !empty($planoption->translations->{get_lang()}->title)
                                ? $planoption->translations->{get_lang()}->title
                                : $planoption->title }}</span>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</div>

