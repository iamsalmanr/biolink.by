@extends('admin.layouts.main')
@section('title', ___('Advertisements'))
@section('header_buttons')
    <a href="#" data-url="{{ route('admin.advertisements.edit', $headAd->id) }}" data-toggle="slidePanel" class="btn btn-primary"><i class="icon-feather-code me-2"></i> {{ ___('Head Code') }}</a>
@endsection
@section('content')
    <div class="quick-card card">
        <div class="card-body">
            <div class="dataTables_wrapper">
                <table class="table table-striped" id="ajax_datatable" data-jsonfile="{{ route('admin.advertisements.index') }}" data-order-dir="asc">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ ___('Title') }}</th>
                        <th>{{ ___('Status') }}</th>
                        <th width="20" class="no-sort" data-priority="1"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @push('scripts_at_top')
        <script type="text/javascript">
            "use strict";
            var QuickMenu = {"page": "advertisements"};
        </script>
    @endpush
    @push('styles_vendor')
        <link rel="stylesheet" href="{{ asset('admin/assets/plugins/codemirror/codemirror.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/plugins/codemirror/monokai.min.css') }}">
    @endpush
    @push('scripts_vendor')
        <script src="{{ asset('admin/assets/plugins/codemirror/codemirror.min.js') }}"></script>
        <script src="{{ asset('admin/assets/plugins/codemirror/htmlmixed.js') }}"></script>
        <script src="{{ asset('admin/assets/plugins/codemirror/xml.js') }}"></script>
        <script src="{{ asset('admin/assets/plugins/codemirror/javascript.min.js') }}"></script>
        <script src="{{ asset('admin/assets/plugins/codemirror/sublime.min.js') }}"></script>
    @endpush
@endsection
