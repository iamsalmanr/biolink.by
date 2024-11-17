@extends('admin.layouts.main')
@section('title', ___('Email Templates').' - '. strtoupper($current_language))
@section('header_buttons')
    @include('admin.includes.language')
@endsection
@section('content')
    <div class="quick-card card">
        <div class="card-body">
            <div class="dataTables_wrapper">
                <table id="basic_datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ ___('Language') }}</th>
                            <th>{{ ___('Title') }}</th>
                            <th>{{ ___('Subject') }}</th>
                            <th>{{ ___('Status') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($mailTemplates as $mailTemplate)
                        <tr class="item">
                            <td class="text-uppercase">{{ $mailTemplate->language->code }}</td>
                            <td>{{ $mailTemplate->name }}</td>
                            <td>{{ $mailTemplate->subject }}</td>
                            <td>
                                @if ($mailTemplate->status)
                                    <span class="badge bg-success">{{ ___('Active') }}</span>
                                @else
                                    <span class="badge bg-danger">{{ ___('Disabled') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="#" data-url="{{ route('admin.mailtemplates.edit', $mailTemplate->id) }}" data-toggle="slidePanel" title="{{___('Edit')}}" data-tippy-placement="top" class="btn btn-default btn-icon me-1"><i class="icon-feather-edit"></i></a>
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
            var QuickMenu = {"page": "email-template"};
        </script>
    @endpush
    @push('scripts_vendor')
        <script src="{{ asset('admin/assets/plugins/tinymce/tinymce.min.js') }}"></script>
    @endpush
@endsection
