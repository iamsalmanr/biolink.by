@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="fas fa-users"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ number_format($total_users) }}</h4>
                    </div>
                    <p class="mb-0 fs-6">{{ ___('Total Users') }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-danger"><i class="fas fa-user-plus"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ number_format($current_month_users) }}</h4>
                    </div>
                    <p class="mb-0 fs-6">{{ ___('Current Month Users') }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning"><i
                                    class="fas fa-money-bills"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ price_symbol_format($total_earnings) }}</h4>
                    </div>
                    <p class="mb-0 fs-6">{{ ___('Total Earnings') }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-info">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-info"><i class="far fa-money-bills"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ price_symbol_format($current_month_earnings) }}</h4>
                    </div>
                    <p class="mb-0 fs-6">{{ ___('Current Month Earnings') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="quick-card card">
                <div class="card-header">
                    <h5>{{ ___('Earnings Statistics') }}</h5>
                </div>
                <div class="card-body">
                    <div class="chart quick-chart">
                        <canvas height="310" id="quickcms-earnings-charts"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="quick-card card">
                <div class="card-header">
                    <h5>{{ ___('Weekly users') }}</h5>
                </div>
                <div class="card-body">
                    <div class="chart quick-chart">
                        <canvas height="310" id="quickcms-users-charts"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-12 mb-4">
            <div class="quick-card card mb-0 h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>{{ ___('Recent Registered') }}</h5>
                    <div>
                        <a class="btn btn-sm btn-primary"
                           href="{{ route('admin.users.index') }}">{{ ___('View All') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ ___('Name') }}</th>
                                <th>{{ ___('Email') }}</th>
                                <th>{{ ___('Date') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2"><img
                                                    src="{{asset('storage/users/'.$user->avatar)}}"
                                                    alt="{{ $user->name }}" class="rounded-circle"></div>
                                            <a class="text-body text-truncate fw-semibold"
                                               href="{{ route('admin.users.edit', $user->id) }}">{{ $user->name }}</a>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-truncate">{{ $user->created_at->diffforhumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        {{___('No Data Found.')}}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12 mb-4">
            <div class="quick-card card mb-0 h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>{{ ___('Transactions') }}</h5>
                    <div>
                        <a class="btn btn-sm btn-primary"
                           href="{{ route('admin.transactions.index') }}">{{ ___('View All') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @forelse ($transactions as $transaction)
                            <li class="d-flex {{ ($loop->last) ? '' : 'mb-4 pb-1' }}">
                                <div class="avatar avatar-sm flex-shrink-0 me-3">
                                    <img src="{{asset('storage/users/'.$transaction->user->avatar)}}"
                                            alt="{{ $transaction->user->name }}" class="rounded-circle" title="{{ $transaction->user->name }}">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-1">{{ $transaction->details->title }}</h6>
                                        <small class="text-muted d-block">{{ $transaction->created_at->diffforhumans() }}</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0">{{ price_symbol_format($transaction->total) }}</h6>
                                    </div>
                                </div>
                            </li>
                        @empty
                            {{___('No Data Found.')}}
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts_at_top')
        <script type="text/javascript">
            "use strict";
            const QuickMenu = {"page": "dashboard"};
        </script>
    @endpush
    @push('scripts_vendor')
        <script src="{{ asset('admin/assets/js/chart.min.js') }}"></script>
        <script>
            const CURRENCY_CODE = @json($settings->currency->symbol);
            const CURRENCY_POSITION = @json($settings->currency->position);
            const earningChart = document.getElementById("quickcms-earnings-charts");
            new Chart(earningChart, {
                type: 'line',
                data: {
                    labels: @json($earningData['labels']),
                    datasets: [{
                        label: @json(___('Earnings')),
                        data: @json($earningData['data']),
                        fill: true,
                        backgroundColor: '#d3f5d8',
                        borderColor: '#30b244',
                        borderWidth: "2",
                        pointRadius: 5,
                        pointHoverRadius: 5,
                        pointHitRadius: 10,
                        pointBackgroundColor: "#fff",
                        pointHoverBackgroundColor: "#30b244",
                        pointBorderWidth: "2",
                        tension: 0.3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';

                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        if (CURRENCY_POSITION == 1) {
                                            label += CURRENCY_CODE + context.parsed.y;
                                        } else {
                                            label += context.parsed.y + CURRENCY_CODE;
                                        }
                                    }
                                    return label;
                                }
                            },
                            backgroundColor: '#333',
                            titleFontSize: 13,
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            bodyFontSize: 13,
                            displayColors: false,
                            xPadding: 10,
                            yPadding: 10,
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                    if (CURRENCY_POSITION == 1) {
                                        return CURRENCY_CODE + ' ' + value;
                                    } else {
                                        return value + CURRENCY_CODE;
                                    }
                                }
                            },
                            suggestedMax: @json($earningData['max']),
                        }
                    },
                }
            });

            const usersChart = document.getElementById("quickcms-users-charts");
            new Chart(usersChart, {
                type: 'bar',
                data: {
                    labels: @json($usersData['labels']),
                    datasets: [{
                        label: @json(___('Users')),
                        fill: true,
                        data: @json($usersData['data']),
                        backgroundColor: '#bdc4f3',
                        borderColor: '#bdc4f3',
                        borderWidth: "2",
                        pointRadius: 5,
                        pointHoverRadius: 5,
                        pointHitRadius: 10,
                        pointBackgroundColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointBorderWidth: "2",
                        tension: 0.3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            suggestedMax: @json($usersData['max']),
                        }
                    },
                    plugins: {
                        title: {
                            display: false
                        },
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: '#333',
                            titleFontSize: 13,
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            bodyFontSize: 13,
                            displayColors: false,
                            xPadding: 10,
                            yPadding: 10,
                            intersect: false
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection

