@extends('admin.layouts.main')
@section('title', ___('Payment Gateways'))
@section('content')

    <div class="quick-card card">
        <div class="card-body">
            <div class="dataTables_wrapper">
                <table id="basic_datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ ___('Logo') }}</th>
                            <th>{{ ___('name') }}</th>
                            <th>{{ ___('Fees') }}</th>
                            <th>{{ ___('Status') }}</th>
                            <th width="20" class="no-sort" data-priority="1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gateways as $gateway)
                            <tr class="item">
                                <td>
                                    <a href="{{ route('admin.gateways.edit', $gateway->id) }}">
                                        <img src="{{ asset('storage/payments/'.$gateway->logo) }}" height="35" width="100">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.gateways.edit', $gateway->id) }}" class="text-dark">
                                        {{ $gateway->name }}
                                    </a>
                                </td>
                                <td>{{ $gateway->fees }}%</td>
                                <td>
                                    @if ($gateway->status)
                                        <span class="badge bg-success">{{ ___('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ ___('Disabled') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                    <a href="#" data-url="{{ route('admin.gateways.edit', $gateway->id) }}" data-toggle="slidePanel" title="{{___('Edit')}}" data-tippy-placement="top" class="btn btn-default btn-icon"><i class="icon-feather-edit"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts_at_top')
        <script id="quick-sidebar-menu-js-extra">
            "use strict";
            var QuickMenu = {"page": "gateways"};
        </script>
    @endpush
@endsection
