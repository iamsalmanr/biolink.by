@extends('admin.layouts.main')
@section('title', 'Edit Password')
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            @include('admin.users.userdetails')
        </div>
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item"><a class="nav-link " href="{{ route('admin.users.edit', $user->id) }}"><i class="icon-feather-user me-2"></i>{{ ___('Account details') }}</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('admin.users.password', $user->id) }}"><i
                            class="icon-feather-lock me-2"></i>{{ ___('Password') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.logs', $user->id) }}"><i class="icon-feather-list me-2"></i>{{ ___('Login logs') }}</a></li>
            </ul>

            <form action="{{ route('admin.users.password', $user->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5>{{ ___('Update Password') }}</h5>
                    </div>
                    <div class="card-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                        <label class="form-label">{{ ___('Password') }} *</label>
                                        <input type="password" name="password" class="form-control"
                                               value="" required>
                                </div>
                                <div class="col-lg-6">
                                        <label class="form-label">{{ ___('Confirm Password') }} *</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                               value="" required>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">{{ ___('Save Changes') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts_at_top')
        <script type="text/javascript">
            "use strict";
            var QuickMenu = {"page": "users"};
        </script>
    @endpush
@endsection
