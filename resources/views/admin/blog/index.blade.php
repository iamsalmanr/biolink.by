@extends('admin.layouts.main')
@section('title', ___('Blogs').' - '. strtoupper($current_language))
@section('header_buttons')
    @include('admin.includes.language')
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary ms-2"><i class="icon-feather-plus me-2"></i> {{ ___('Add New') }}</a>
@endsection
@section('content')
    <div class="quick-card card">
        <div class="card-body">
            <div class="dataTables_wrapper">
                <table class="table table-striped" id="ajax_datatable" data-jsonfile="{{ route('admin.blogs.index') }}?lang={{ $lang }}">
                    <thead>
                    <tr>
                        <th class="tb-w-2x">#</th>
                        <th class="tb-w-3x">{{ ___('Language') }}</th>
                        <th class="tb-w-20x">{{ ___('Title') }}</th>
                        <th class="tb-w-7x">{{ ___('Category') }}</th>
                        <th class="tb-w-3x">{{ ___('Comments') }}</th>
                        <th class="tb-w-7x">{{ ___('Created At') }}</th>
                        <th width="20" class="no-sort" data-priority="1"></th>
                        <th width="20" class="no-sort" data-priority="1">
                            <div class="checkbox">
                                <input type="checkbox" id="quick-checkbox-all">
                                <label for="quick-checkbox-all"><span class="checkbox-icon"></span></label>
                            </div>
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Site Action -->
    <div class="site-action">
        <div class="site-action-buttons">
            <button type="button" id="quick-delete-button" data-action="{{ route('admin.blogs.delete') }}"
                    class="btn btn-danger btn-floating animation-slide-bottom">
                <i class="icon icon-feather-trash-2" aria-hidden="true"></i>
            </button>
        </div>
        <button class="front-icon btn btn-primary btn-floating"
           onclick="window.location = '{{ route('admin.blogs.create') }}'">
            <i class="icon-feather-plus animation-scale-up" aria-hidden="true"></i>
        </button>
        <button type="button" class="back-icon btn btn-primary btn-floating">
            <i class="icon-feather-x animation-scale-up" aria-hidden="true"></i>
        </button>
    </div>

    @push('scripts_at_top')
        <script type="text/javascript">
            "use strict";
            var QuickMenu = {"page": "blog", "subpage": "all-blogs"};
        </script>
    @endpush
@endsection
