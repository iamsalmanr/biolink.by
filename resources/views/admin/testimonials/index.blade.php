@extends('admin.layouts.main')
@section('title', ___('Testimonials'))
@section('header_buttons')
    <a href="#" data-url="{{ route('admin.testimonials.create') }}" data-toggle="slidePanel" class="btn btn-primary ms-2"><i class="icon-feather-plus me-2"></i> {{ ___('Add New') }}</a>
@endsection
@section('content')
    <div class="quick-card card">
        <div class="card-body">
            <div class="dataTables_wrapper">
                <table class="table table-striped" id="ajax_datatable" data-jsonfile="{{ route('admin.testimonials.index') }}">
                    <thead>
                    <tr>
                        <th>{{ ___('Name') }}</th>
                        <th>{{ ___('Content') }}</th>

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
            <button type="button" id="quick-delete-button" data-action="{{ route('admin.testimonials.delete') }}"
                    class="btn btn-danger btn-floating animation-slide-bottom">
                <i class="icon icon-feather-trash-2" aria-hidden="true"></i>
            </button>
        </div>
        <button type="button" class="front-icon btn btn-primary btn-floating"
                data-url="{{ route('admin.testimonials.create') }}" data-toggle="slidePanel">
            <i class="icon-feather-plus animation-scale-up" aria-hidden="true"></i>
        </button>
        <button type="button" class="back-icon btn btn-primary btn-floating" >
            <i class="icon-feather-x animation-scale-up" aria-hidden="true"></i>
        </button>
    </div>
    @push('scripts_at_top')
        <script id="quick-sidebar-menu-js-extra">
            "use strict";
            var QuickMenu = {"page": "testimonials"};
        </script>
    @endpush
@endsection
