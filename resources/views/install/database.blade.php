@extends('install.layout')
@section('content')
    <form action="{{ route('install.database') }}" method="post">
        @csrf
        <div class="quick-card card">
            <div class="card-header">
                <h5 class="text-center">{{ ___('Database Configuration') }}</h5>
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
                    <label class="form-label" for="database-hostname">{{ ___('Database Hostname') }}</label>
                    <input type="text" name="database_hostname" id="database-hostname"
                           value="{{ old('database_hostname') ?? '127.0.0.1' }}"
                           class="form-control{{ $errors->has('database_hostname') ? ' is-invalid' : '' }}">
                    @if ($errors->has('database_hostname'))
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('database_hostname') }}</strong>
                            </span>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label" for="database-port">{{ ___('Database Port') }}</label>
                    <input type="number" name="database_port" id="database-port"
                           value="{{ old('database_port') ?? '3306' }}"
                           class="form-control{{ $errors->has('database_port') ? ' is-invalid' : '' }}">
                    @if ($errors->has('database_port'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('database_port') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3 {{ $errors->has('database_name') ? ' has-error ' : '' }}">
                    <label class="form-label" for="database-name">{{ ___('Database Name') }}</label>
                    <input type="text" name="database_name" id="database-name"
                           class="form-control{{ $errors->has('database_name') ? ' is-invalid' : '' }}"
                           value="{{ old('database_name') }}">
                    @if ($errors->has('database_name'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('database_name') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label" for="database-username">{{ ___('Database Username') }}</label>
                    <input type="text" name="database_username" id="database-username"
                           class="form-control{{ $errors->has('database_username') ? ' is-invalid' : '' }}"
                           value="{{ old('database_username') }}">
                    @if ($errors->has('database_username'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('database_username') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label" for="database-password">{{ ___('Database User Password') }}</label>
                    <input type="password" name="database_password" id="database-password"
                           class="form-control{{ $errors->has('database_password') ? ' is-invalid' : '' }}"
                           value="{{ old('database_password') }}">
                    @if ($errors->has('database_password'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('database_password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{ ___('Next') }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection
