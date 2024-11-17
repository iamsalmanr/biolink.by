@extends('admin.layouts.main')
@section('title', ___('Pages') .' - '. strtoupper($current_language))
@section('header_buttons')
    @include('admin.includes.language')
    <a href="#" data-url="{{ route('admin.pages.create') }}" data-toggle="slidePanel" class="btn btn-primary ms-2"><i class="icon-feather-plus me-2"></i> {{ ___('Add New') }}</a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
        <div class="dataTables_wrapper">
            <table id="basic_datatable" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ ___('Language') }}</th>
                    <th>{{ ___('Title') }}</th>
                    <th>{{ ___('Created At') }}</th>
                    <th width="20" class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr class="item">
                        <td>{{ $page->id }}</td>
                        <td><span class="text-uppercase">{{ $page->language->code }}</span></td>
                        <td>
                            <a href="{{ route('page', $page->slug) }}" target="_blank" class="text-body">
                                {{ $page->title }} <i class="far fa-square-up-right"></i>
                            </a>
                        </td>
                        <td>{{ datetime_formating($page->created_at) }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="#" data-url="{{ route('admin.pages.edit', $page->id) }}" data-toggle="slidePanel" title="{{ ___('Edit') }}" class="btn btn-default btn-icon me-2" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit='return confirm("{{___('Are you sure?')}}")'>
                                    @csrf @method('DELETE')
                                    <button class="btn btn-icon btn-danger" title="{{ ___('Delete') }}" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        </div>
    </div>
    <!-- Site Action -->
    <div class="site-action">
        <button type="button" class="front-icon btn btn-primary btn-floating"
                data-url="{{ route('admin.pages.create') }}" data-toggle="slidePanel">
            <i class="icon-feather-plus animation-scale-up" aria-hidden="true"></i>
        </button>
        <button type="button" class="back-icon btn btn-primary btn-floating">
            <i class="icon-feather-x animation-scale-up" aria-hidden="true"></i>
        </button>
    </div>
    @push('scripts_at_top')
        <script type="text/javascript">
            "use strict";
            var QuickMenu = {"page": "pages"};
        </script>
    @endpush
    @push('scripts_vendor')
        <script src="{{ asset('admin/assets/plugins/tinymce/tinymce.min.js') }}"></script>
    @endpush
@endsection
