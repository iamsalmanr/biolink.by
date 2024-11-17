@extends($activeTheme.'layouts.auth')
@section('title', ___('Sign In'))
@section('content')
    <div class="row vh-100 g-0 login-wrapper">
        <!-- Left Side -->
        <div class="col-lg-5 position-relative d-none d-lg-block">
            <div class="bg"></div>
        </div>
        <!--/ Left Side -->

        <!-- Right Side -->
        <div class="col-lg-7">
            <div class="row align-items-center justify-content-center h-100 g-0 px-16 py-50 px-sm-0">
                <div class="col col-sm-6 col-lg-7 col-xl-6">

                    <div class="text-center">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/brand/'.$settings->media->dark_logo) }}"
                                 alt="{{ @$settings->site_title }}" class="logo mb-30"/>
                        </a>
                    </div>

                    <h2 class="text-center font-30">{{ ___('Login Here!') }}</h2>

                    <form action="{{ route('login') }}" method="POST" class="mt-32">
                        @csrf
                        <div class="form-group mt-16">
                            <label class="form-label">{{ ___('Email address') }} *</label>
                            <input type="email" name="email" class="form-control input-with-br -h-48"
                                   placeholder="{{ ___('Email address') }}" value="{{ old('email') }}" required />
                        </div>

                        <div class="form-group mt-16">
                            <label class="form-label">{{ ___('Password') }} *</label>
                            <input type="password" name="password" class="form-control input-with-br -h-48"
                                   placeholder="{{ ___('Password') }}" required />
                        </div>
                        <div class="form-group mt-16 mb-16">
                            <div class="d-flex justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberme" checked>
                                    <label class="form-check-label" for="rememberme">{{ ___('Remember Me') }}</label>
                                </div>
                                <a href="{{ route('password.request') }}">{{ ___('Forgot Password?') }}</a>
                            </div>
                        </div>

                        {!! display_captcha() !!}

                        <button type="submit" class="button bg-primary text-white w-100 rounded-pill -h-48">Login</button>

                        @if (@$settings->facebook_login->status || @$settings->google_login->status)
                            <div class="block-bf-af position-relative d-flex align-items-center font-16 mt-32 mb-32 justify-content-center"> {{ ___('or Login with') }} </div>

                            @if (@$settings->google_login->status)
                                <a href="{{route('social.login', 'google')}}" class="button -outlined -light -br-2 rounded-pill w-100 -h-48">
                                    <svg width="24" height="24" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0)">
                                            <path d="M49.0079 25.5741C49.0079 23.8746 48.8701 22.166 48.5761 20.4941H24.9954V30.1212H38.499C37.9386 33.2261 36.1381 35.9727 33.5017 37.7181V43.9647H41.5579C46.2888 39.6104 49.0079 33.1802 49.0079 25.5741Z" fill="#4285F4"/>
                                            <path d="M24.9954 50C31.738 50 37.4242 47.7861 41.5672 43.9647L33.5109 37.7181C31.2695 39.243 28.3759 40.1065 25.0046 40.1065C18.4825 40.1065 12.9524 35.7064 10.9682 29.7905H2.65479V36.23C6.89877 44.672 15.5429 50 24.9954 50V50Z" fill="#34A853"/>
                                            <path d="M10.959 29.7907C9.91177 26.6858 9.91177 23.3237 10.959 20.2188V13.7793H2.65474C-0.891098 20.8434 -0.891098 29.166 2.65474 36.2301L10.959 29.7907V29.7907Z" fill="#FBBC04"/>
                                            <path d="M24.9954 9.89366C28.5596 9.83855 32.0044 11.1797 34.5857 13.6416L41.7233 6.50399C37.2037 2.26 31.2052 -0.073269 24.9954 0.000219877C15.5429 0.000219877 6.89877 5.32816 2.65479 13.7794L10.959 20.2189C12.934 14.2938 18.4733 9.89366 24.9954 9.89366V9.89366Z" fill="#EA4335"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0">
                                                <rect width="49.0079" height="50" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg> <span class="ml-16 fw-bold font-16">{{ ___("Login With Google") }}</span></a>
                            @endif

                            @if (@$settings->facebook_login->status)
                                <a href="{{route('social.login', 'facebook')}}" class="button -outlined -light -br-2 mt-16 rounded-pill w-100 -h-48 fw-bold font-16"><i class="fa-brands fa-facebook text-facebook mr-16 font-24"></i><span>{{ ___("Login With Facebook") }}</span></a>
                            @endif
                        @endif
                    </form>
                    <div class="text-center mt-32">
                        <a class="text-decoration-underline" href="{{ route('register') }}">{{ ___("Don't have an account? Sign Up Now") }}</a>
                    </div>

                    @if(demo_mode())
                        <table class="table my-30 table-bordered">
                            <tr>
                                <th></th>
                                <th>{{ ___('Email address') }}</th>
                                <th>{{ ___('Password') }}</th>
                            </tr>
                            <tr>
                                <th>Admin</th>
                                <td>adminuser@gmail.com</td>
                                <td>12345678</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>demouser@gmail.com</td>
                                <td>12345678</td>
                            </tr>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        <!--/ Right Side -->
    </div>
@endsection
