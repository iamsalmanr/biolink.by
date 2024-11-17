@extends('install.layout')
@section('content')
    <form action="{{ route('install.admin') }}" method="post">
        @csrf

        <div class="quick-card card">
            <div class="card-header">
                <h5 class="text-center">{{ ___('Admin credentials') }}</h5>
            </div>
            <div class="card-body">

                @if (\Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ \Session::get('error') }}
                        <button type="button"
                                class="btn d-flex align-items-center justify-content-center p-0"
                                data-dismiss="alert" aria-label="{{ ___('Close') }}">
                            <span aria-hidden="true"
                                  class="d-flex align-items-center"><i class="far fa-close"></i></span>
                        </button>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label" for="purchase_code">{{ ___('Purchase Code') }}</label>
                    <input id="purchase_code" type="text"
                           class="form-control{{ $errors->has('purchase_code') ? ' is-invalid' : '' }}" name="purchase_code"
                           value="{{ old('purchase_code') }}" autofocus required>
                    @if ($errors->has('purchase_code'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('purchase_code') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label" for="firstname">{{ ___('Admin First Name') }}</label>
                    <input id="firstname" type="text"
                           class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname"
                           value="{{ old('firstname') }}" autofocus>
                    @if ($errors->has('firstname'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('firstname') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label" for="lastname">{{ ___('Admin Last Name') }}</label>
                    <input id="lastname" type="text"
                           class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname"
                           value="{{ old('lastname') }}" autofocus>
                    @if ($errors->has('lastname'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('lastname') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label" for="username">{{ ___('Admin Username') }}</label>
                    <input id="username" type="text"
                           class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username"
                           value="{{ old('username') }}" autofocus>
                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">{{ ___('Admin Email address') }}</label>
                    <input id="email" type="text" dir="ltr"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">{{ ___('Admin Password') }}</label>
                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                           value="{{ old('password') }}">
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password-confirmation">{{ ___('Confirm password') }}</label>
                    <input id="password-confirmation" type="password"
                           class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                           name="password_confirmation" value="{{ old('password_confirmation') }}">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{ ___('Next') }}</button>
                </div>
            </div>
        </div>

    </form>
@endsection
