@extends($activeTheme.'layouts.main')
@section('title', ___('Payment confirm'))
@section('content')
    <div class="container pt-100">
        <div class="my-50">
            <div class="row">
                <div class="col-lg-6 m-auto">
                    <div class="title-head mb-30">
                        <h1 class="mb-0">{{ ___('Payment details') }}</h1>
                    </div>
                    <div class="card mb-30">
                        <table class="table table-bordered table-striped mb-20">
                            <tbody>
                            <tr>
                                <td class="p-3"><strong>{{ ___('Title') }}</strong></td>
                                <td class="p-3">{{ $transaction->details->title }}
                                    @if(!empty(@$transaction->details->interval))
                                        <span class="text-capitalize text-muted">({{ plan_interval_text($transaction->details->interval) }})</span></td>
                                    @endif
                            </tr>
                            <tr>
                                <td class="p-3"><strong>{{ ___('Price') }}</strong></td>
                                <td class="p-3">{{ price_symbol_format($transaction->details->price) }}</td>
                            </tr>
                            @php
                                $discount = 0;
                            @endphp
                            @if ($transaction->coupon)
                                @php
                                    $discount = ($transaction->details->price * $transaction->coupon->percentage) / 100;
                                @endphp
                                <tr>
                                    <td class="p-3"><strong>{{ ___('Discount') }}</strong>
                                        ({{ $transaction->coupon->percentage }}%)
                                    </td>
                                    <td class="p-3 text-danger">
                                        -{{ price_symbol_format($discount) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-3">
                                        <h6 class="mb-0"><strong>{{ ___('Subtotal') }}</strong></h6>
                                    </td>
                                    <td class="p-3">
                                        <h6 class="mb-0">
                                            <strong>{{ price_symbol_format($transaction->details->price - $discount) }}</strong>
                                        </h6>
                                    </td>
                                </tr>
                            @endif

                            @if($transaction->taxes)
                                @foreach($transaction->taxes as $tax)
                                    @php
                                        $calculated_tax = (($transaction->details->price - $discount) * $tax->percentage) / 100;
                                    @endphp
                                <tr>
                                    <td class="p-3"><strong>{{ ___('Tax') }}</strong>
                                        ({{ $tax->percentage }}%)
                                    </td>
                                    <td class="p-3">+{{ price_symbol_format($calculated_tax) }}</td>
                                </tr>
                                @endforeach
                            @endif

                            @if($transaction->fees)
                                <tr>
                                    <td class="p-3"><strong>{{ ___('Gateway fees') }}</strong></td>
                                    <td class="p-3">
                                        +{{ price_symbol_format($transaction->fees) }}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td class="p-3">
                                    <h5 class="mb-0"><strong>{{ ___('Total') }}</strong></h5>
                                </td>
                                <td class="p-3">
                                    <h5 class="mb-0">
                                        <strong>{{ price_code_format($transaction->total + $transaction->fees) }}</strong>
                                    </h5>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <form action="{{ route('ipn.razorpay') }}" method="POST">
                                    @csrf
                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            @foreach ($details as $key => $value)
                                            data-{{ $key }}="{{ $value }}" @endforeach>
                                    </script>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('subscription') }}"
                                   class="button -secondary -lg w-100">{{ ___('Cancel Payment') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts_at_bottom')
        <script>
            "use strict";
            $('.razorpay-payment-button').addClass('button -primary -lg w-100');
        </script>
    @endpush
@endsection

