@extends('admin.layouts.main')
@section('title', ___('Navbar Menu').' - '. strtoupper($current_language))

@section('header_buttons')
    @include('admin.includes.language')
    <a href="#" data-url="{{route('admin.navbarMenu.create')}}" data-toggle="slidePanel"
       class="btn btn-info ms-2">{{ ___('Add New') }}</a>
    <form action="{{ route('admin.navbarMenu.order') }}" method="POST" class="d-inline-block">
        @csrf
        <input name="ids" id="ids" hidden>

        <button
            class="btn btn-primary ms-2 {{$links->count() == 0 ? 'disabled' : ''}}">{{ ___('Save') }}</button>
    </form>
@endsection

@section('content')
    @if ($links->count() > 0)
        <div class="card overflow-hidden">
            <div class="dd nestable">
                <ol class="dd-list">
                    @foreach ($links as $link)
                        <li class="dd-item" data-id="{{ $link->id }}">
                            <div class="dd-handle">
                                <span class="drag-indicator"></span>
                                <span class="dd-title">{{ $link->name }}</span>
                                <div class="dd-nodrag ms-auto d-flex">
                                    <a href="#" data-url="{{ route('admin.navbarMenu.edit', $link->id) }}"
                                       data-toggle="slidePanel" title="{{ ___('Edit') }}"
                                       data-tippy-placement="top"
                                       class="btn btn-default btn-icon me-1"><i class="icon-feather-edit"></i></a>
                                    <form class="d-inline"
                                          action="{{ route('admin.navbarMenu.destroy', $link->id) }}"
                                          method="POST" onsubmit='return confirm("{{___('Are you sure?')}}")'>
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-icon btn-danger"><i class="icon-feather-trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if (count($link->children))
                                <ol class="dd-list">
                                    @foreach ($link->children as $child)
                                        <li class="dd-item" data-id="{{ $child->id }}">
                                            <div class="dd-handle">
                                                <span class="drag-indicator"></span>
                                                <span class="dd-title">{{ $child->name }}</span>
                                                <div class="dd-nodrag ms-auto d-flex">
                                                    <a href="#"
                                                       data-url="{{ route('admin.navbarMenu.edit', $child->id) }}"
                                                       data-toggle="slidePanel" title="{{ ___('Edit') }}"
                                                       data-tippy-placement="top"
                                                       class="btn btn-default btn-icon me-2"><i
                                                            class="icon-feather-edit"></i></a>
                                                    <form class="d-inline"
                                                          action="{{ route('admin.navbarMenu.destroy', $child->id) }}"
                                                          method="POST"
                                                          onsubmit='return confirm("{{___('Are you sure?')}}")'>
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-icon btn-danger"><i
                                                                class="icon-feather-trash-2"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    @else
        <div class="quick-card card">
            <div class="card-body">
                {{___('No Data Found.')}}
            </div>
        </div>
    @endif
    @push('scripts_at_top')
        <script type="text/javascript">
            "use strict";
            var QuickMenu = {"page": "navigation", "subpage": "navbarMenu"};
        </script>
    @endpush
    @if ($links->count() > 0)
        @push('styles_vendor')
            <link rel="stylesheet" href="{{ asset('admin/assets/plugins/nestable/jquery.nestable.min.css') }}">
        @endpush
        @push('scripts_vendor')
            <script src="{{ asset('admin/assets/plugins/nestable/jquery.nestable.min.js') }}"></script>
        @endpush
    @endif
@endsection
