@extends($activeTheme.'layouts.app')
@section('title', ___('Transactions'))
@section('content')
    <div class="d-flex justify-content-between align-items-center pb-30">
        <div class="title-head">
            <h1 class="mb-0">{{ ___('Transactions') }}</h1>
        </div>
    </div>

        <div class="card">
            <div class="card-header mb-16">
                <h2 class="card-title">{{ ___('Transactions') }}</h2>
            </div>
            <div class="card-body">
                <div class="dash-table">
                    <div class="table-responsive">
                    <table class="table table-striped table-light mb-0">
                        <thead>
                        <tr>
                            <th>{{ ___('ID') }}</th>
                            <th class="text-center">{{ ___('Price') }}</th>
                            <th class="text-center"><span
                                    class="d-none d-lg-inline">{{ ___('Payment Method') }}</span>
                            </th>
                            <th class="text-center">{{ ___('Date') }}</th>
                            <th class="text-center">{{ ___('Status') }}</th>
                            <th class="text-center">{{ ___('Invoice') }}</th>
                        </tr>
                        </thead>
                        @if ($transactions->count() > 0)
                        <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>#{{ $transaction->id }}</td>
                                <td class="text-center">
                                    {{ price_symbol_format($transaction->total) }}
                                </td>
                                <td class="text-center"><span
                                        class="d-none d-lg-inline">{{ $transaction->paymentGateway->name ?? '-' }}</span>
                                </td>
                                <td class="text-center">{{ date_formating($transaction->created_at) }}</td>
                                <td class="text-center">
                                    @if ($transaction->status == \App\Models\Transaction::STATUS_PAID)
                                        @if ($transaction->total > 0)
                                            <span
                                                class="badge bg-success text-light">{{ ___('Paid') }}</span>
                                        @else
                                            <span
                                                class="badge bg-primary text-light">{{ ___('Done') }}</span>
                                        @endif
                                    @elseif($transaction->status == \App\Models\Transaction::STATUS_PENDING)
                                        <span
                                            class="badge bg-warning text-light">{{ ___('Pending') }}</span>
                                    @else
                                        <span
                                            class="badge bg-danger text-light">{{ ___('Cancelled') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($transaction->status == \App\Models\Transaction::STATUS_PAID && $transaction->total > 0)
                                    <a title="{{ ___('Invoice') }}" href="{{route('invoice', $transaction->id)}}" target="_blank"><i class="fas fa-paperclip"></i></a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">{{ ___('No Data Found') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>

@endsection
