@extends('install.layout')
@section('content')
    <div id="welcome" class="step mt-4">
        <h1 class="page-title">{{ ___('QuickCMS Installation') }}</h1>
        <p>
            {{ ___('Welcome! QuickCMS is an custom content management system developed by Bylancer developers.') }}
        </p>
        <p class="fw-semibold mb-40">
            {{ ___('Installation process is very easy and it takes less than 2 minutes!') }}
        </p>

        <a href="{{ route('install.requirements') }}" class="btn btn-primary">{{ ___('Start Installation') }}</a>
    </div>
@endsection
