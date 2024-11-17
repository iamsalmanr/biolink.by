<!DOCTYPE html>
<html lang="{{ get_lang() }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ ___('Invoice') . ' #'. $transaction->id}}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/brand/'.$settings->media->favicon) }}">
    <meta name="theme-color" content="{{ $settings->colors->primary_color }}">
    <style>
        :root {
            --theme-color: {{ $settings->colors->primary_color }};
        }
    </style>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/invoice.css') }}">
</head>
<body>
<!-- Print Button -->
<div class="print-button-container">
    <a href="javascript:window.print()" class="print-button">{{___('Print this invoice')}}</a>
</div>
<!-- Invoice -->
<div id="invoice">
    <!-- Header -->
    <div class="row">
        <div class="col-xl-6">
            <div id="logo">
                <img src="{{ asset('storage/brand/'.$settings->media->dark_logo) }}" alt="{{ @$settings->site_title }}">
            </div>
        </div>
        <div class="col-xl-6">
            <p id="details">
                <strong>{{___('Invoice')}}
                    :</strong> {{$transaction->seller->invoice_number_prefix ?? 'INV-'}}{{$transaction->id}} <br>
                <strong>{{___('Date')}}:</strong> {{ datetime_formating($transaction->created_at) }} </p>
        </div>
    </div>


    <!-- Client & Supplier -->
    <div class="row">
        <div class="col-xl-12">
            <h2>{{___('Invoice')}}</h2>
        </div>
        <div class="col-md-6">
            <h3>{{___('Supplier')}}</h3>
            <p>
                @if(!empty($transaction->seller->name))
                    <strong>{{___('Name')}}</strong> {{$transaction->seller->name}}<br>
                @endif
                @if(!empty($transaction->seller->address))
                    <strong>{{___('Address')}}</strong> {{$transaction->seller->address}}<br>
                @endif
                @if(!empty($transaction->seller->city))
                    <strong>{{___('City')}}</strong> {{$transaction->seller->city}}<br>
                @endif
                @if(!empty($transaction->seller->state))
                    <strong>{{___('State')}}</strong> {{$transaction->seller->state}}<br>
                @endif
                @if(!empty($transaction->seller->zipcode))
                    <strong>{{___('Zip Code')}}</strong> {{$transaction->seller->zipcode}}<br>
                @endif
                @if(!empty($transaction->seller->country))
                    <strong>{{___('Country')}}</strong> {{$transaction->seller->country}}<br>
                @endif
                @if(!empty($transaction->seller->tax_type) && !empty($transaction->seller->tax_id))
                    <strong>{{$transaction->seller->tax_type}}</strong> {{$transaction->seller->tax_id}}<br>
                @endif
            </p>
        </div>
        <div class="col-md-6">
            <h3>{{___('Customer')}}</h3>
            <p>
                <strong>{{___('Name')}}</strong> {{ $transaction->customer->name }}<br>
                <strong>{{___('Address')}}</strong> {{ $transaction->customer->address }}<br>
                <strong>{{___('City')}}</strong> {{ $transaction->customer->city }}<br>
                <strong>{{___('State')}}</strong> {{ $transaction->customer->state }}<br>
                <strong>{{___('Zip Code')}}</strong> {{ $transaction->customer->zip }}<br>
                <strong>{{___('Country')}}</strong> {{ $transaction->customer->country }}<br>
            </p>
        </div>
    </div>
    <!-- Invoice -->
    <div class="row">
        <div class="col-xl-12">
            <table>
                <tr>
                    <th>{{___('Item')}}</th>
                    <th>{{___('Amount')}}</th>
                </tr>
                <tr>
                    <td>{{ $transaction->details->title }}
                        @if(@$transaction->details->interval)
                        <span class="text-capitalize">({{ plan_interval_text($transaction->details->interval) }})</span>
                        @endif
                    </td>
                    <td>{{ price_symbol_format($transaction->details->price) }}</td>
                </tr>
                @php
                    $discount = 0;
                @endphp
                @if ($transaction->coupon)
                    @php
                        $discount = ($transaction->details->price * $transaction->coupon->percentage) / 100;
                    @endphp
                    <tr>
                        <td>
                            {{___('Discount')}} ({{ $transaction->coupon->percentage }}%)
                            <br><small>{{___('Coupon') }}: <strong>{{$transaction->coupon->code}}</strong></small>
                        </td>
                        <td>-{{ price_symbol_format($discount) }}</td>
                    </tr>
                    <tr>
                        <td>{{___('Subtotal')}}</td>
                        <td>{{ price_symbol_format($transaction->details->price - $discount) }}</td>
                    </tr>
                @endif

                @if($transaction->taxes)
                    @foreach($transaction->taxes as $tax)
                        @php
                            $calculated_tax = (($transaction->details->price - $discount) * $tax->percentage) / 100;
                        @endphp
                    <tr>
                        <td>{{___('Taxes')}} ({{ $tax->percentage }}%)</td>
                        <td>+{{ price_symbol_format($calculated_tax) }}</td>
                    </tr>
                    @endforeach
                @endif

                @if ($transaction->fees)
                    <tr>
                        <td>{{___('Gateway Fees')}}</td>
                        <td>+{{ price_symbol_format($transaction->fees) }}</td>
                    </tr>
                @endif
            </table>
            <table id="totals">
                <tr>
                    <th>{{___('Total')}}
                        @if ($transaction->paymentGateway)
                            <br>
                            <small>{{___('Paid via')}} {{ $transaction->paymentGateway->name }}</small>
                        @endif
                    </th>
                    <th><span>{{ price_symbol_format($transaction->total) }}</span></th>
                </tr>
            </table>
        </div>
    </div>
    <!-- Footer -->
    <div class="row">
        <div class="col-xl-12">
            <ul id="footer">
                <li><span>{{url('/')}}</span></li>
                <li>{{@$transaction->seller->email}}</li>
                <li>{{@$transaction->seller->phone}}</li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
