@extends($activeTheme.'layouts.app')
@section('title', ___('Membership'))
@section('content')
    <div class="d-flex justify-content-between align-items-center pb-30">
        <div class="title-head">
            <h1 class="mb-0">{{ ___('Membership') }}</h1>
        </div>
    </div>
    <h2 class="h5 text-primary mb-20">{{ ___('Current Plan') }}</h2>
    <div class="card d-sm-flex flex-sm-row align-items-sm-center justify-content-between">
        <div class="d-flex align-items-center pe-sm-3">
            <div class="bg-primary-l rounded-1 p-4">
                <i class="far fa-gift fs-1 text-primary d-block"></i>
            </div>
            <div class="ps-3 ps-sm-4">
                <h4 class="mb-3">{{ request()->user()->plan()->name }}
                </h4>
                <div class="d-flex flex-column flex-md-row">
                    <div>
                        <span class="text-capitalize">{{ ___('Expiry Date') }}</span>:
                        @if (request()->user()->plan()->id != 'free')
                        <span class="badge bg-warning font-10 text-white">{{ date_formating(request()->user()->plan_expiration_date) }}</span>
                        @else
                            <span class="badge bg-warning font-10 text-white">-</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-sm-end pt-3 pt-sm-0">
            <a href="{{ route('pricing') }}"
               class="button -primary w-100">
                <i class="fas fa-refresh fs-xl me-1 me-xl-2"></i>
                {{ ___('Change Plan') }}
            </a>
        </div>
    </div>
@endsection
