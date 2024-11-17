@extends($activeTheme.'layouts.auth')
@section('title', ___('Reset Password'))
@section('content')
    <div class="container vh-100 py-10 login-wrapper">
        <div class="row align-items-center justify-content-center h-100">
            <div class="col-md-5">
                <div class="text-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('storage/brand/'.$settings->media->dark_logo) }}"
                             alt="{{ @$settings->site_title }}" class="logo mb-30"/>
                    </a>
                </div>
                <div class="card">
                    <h2 class="text-center font-25 mb-30">{{ ___('Reset Password') }}</h2>
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="form-group mt-16">
                            <label class="form-label">{{ ___('Email address') }} *</label>
                            <input type="email" name="email" class="form-control form-control-md"
                                   value="{{ old('email') }}"
                                   placeholder="{{ ___('Email address') }}" required/>
                        </div>
                        {!! display_captcha() !!}
                        <button type="submit"
                                class="button bg-primary text-white mt-20 w-100 rounded-pill -h-48">{{ ___('Reset') }}</button>
                    </form>
                </div>
                <p class="text-center">&copy; <span>{{date("Y")}}</span>
                        {{ @$settings->site_title }} - {{ ___('All rights reserved') }}.</p>
            </div>
        </div>
    </div>
@endsection
