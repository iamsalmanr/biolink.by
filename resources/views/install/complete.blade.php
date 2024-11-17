@extends('install.layout')
@section('content')
<div class="quick-card card">
    <div class="card-header">
        <h5 class="text-center">{{ ___('Installation Finish') }}</h5>
    </div>
    <div class="card-body">
        <h5 class="mt-4 text-center">{{ ___('Installed') }}</h5>
        <p class="text-center text-muted mb-3">{!! ___(':APP_NAME has been installed.', ['APP_NAME' => '<span class="font-weight-medium">'.env("APP_NAME").'</span>']) !!}</p>
        <div class="text-center">
            <a href="{{ route('home') }}" class="btn btn-primary">{{ ___('Go to Home') }}</a>
        </div>
    </div>
</div>

@endsection
