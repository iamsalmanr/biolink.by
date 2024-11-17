<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Transaction Details') }}</h2>
            </div>
            <div class="slidePanel-actions">
                <button class="btn btn-default btn-icon slidePanel-close" title="{{ ___('Close') }}">
                    <i class="icon-feather-x"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="slidePanel-inner">
        @if ($transaction->status == \App\Models\Transaction::STATUS_CANCELLED)
            <div class="alert alert-danger">
                <p class="mb-0">{{ ___('Transaction has been canceled') }}</p>
            </div>
        @endif
        <div class="card mb-3">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <span>{{ ___('Title') }}</span>
                    <span>
                        {{ $transaction->details->title }}
                        @if(@$transaction->details->interval)
                            <span class="text-capitalize">({{ plan_interval_text($transaction->details->interval) }})</span>
                        @endif
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <span>{{ ___('Price') }}</span>
                    <strong>{{ price_symbol_format($transaction->details->price) }}</strong>
                </li>
                @php
                    $discount = 0;
                @endphp
                @if ($transaction->coupon)
                    @php
                        $discount = ($transaction->details->price * $transaction->coupon->percentage) / 100;
                    @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <span>
                            {{___('Discount')}} ({{ $transaction->coupon->percentage }}%)
                            <br><small>{{___('Coupon') }}: <strong>{{$transaction->coupon->code}}</strong></small>
                        </span>
                        <span
                            class="text-danger"><strong>-{{ price_symbol_format($discount) }}</strong></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <span>{{ ___('Subtotal') }}</span>
                        <strong>{{ price_symbol_format($transaction->details->price - $discount) }}</strong>
                    </li>
                @endif

                @if($transaction->taxes)
                    @foreach($transaction->taxes as $tax)
                        @php
                            $calculated_tax = (($transaction->details->price - $discount) * $tax->percentage) / 100;
                        @endphp
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <span>{{ ___('Taxes') }} ({{ $tax->percentage }}%)</span>
                    <strong>+{{ price_symbol_format($calculated_tax) }}</strong>
                </li>
                    @endforeach
                @endif

                @if ($transaction->fees)
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <span>{{ ___('Gateway Fees') }}</span>
                        <strong>+{{ price_symbol_format($transaction->fees) }}</strong>
                    </li>
                @endif

                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <strong class="text-dark">{{ ___('Total') }}</strong>
                    <strong class="text-dark">{{ price_symbol_format($transaction->total) }}</strong>
                </li>
            </ul>
        </div>

        @if ($transaction->status == \App\Models\Transaction::STATUS_PAID)
            <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" onsubmit='return confirm("{{___('Are you sure?')}}")'>
                @csrf
                @method('PUT')
                <button class="btn btn-label-danger btn-lg w-100">
                    <i class="far fa-times me-2"></i>
                    <span>{{ ___('Cancel Transaction') }}</span>
                </button>
            </form>
        @endif
    </div>
</div>

