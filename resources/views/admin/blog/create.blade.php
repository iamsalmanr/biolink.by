@extends('admin.layouts.main')
@section('title', ___('Add New Blog'))
@section('content')
    <form id="quick-submitted-form" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ ___('Title') }} *</label>
                            <input type="text" name="title" id="create_slug" class="form-control"
                                   value="{{ old('title') }}" required autofocus />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ ___('Slug') }}</label>
                            <input type="text" name="slug" class="form-control"
                                   value="{{ old('slug') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ ___('Image') }} *</label>
                            <div class="d-flex align-items-start justify-content-between gap-4">
                                <div>
                                    <label for="upload" class="btn btn-primary mb-2" tabindex="0">
                                        <i class="fas fa-upload"></i>
                                        <span class="d-none d-sm-block ms-2">{{ ___('Upload Image') }}</span>
                                        <input name="image" type="file" id="upload" hidden
                                               onchange="readURL(this,'uploadedImage')"
                                               accept="image/png, image/jpeg">
                                    </label>
                                    <p class="form-text mb-0">{{ ___('Allowed JPG, JPEG or PNG.') }}</p>
                                </div>
                                <img src="" alt=""
                                     class="d-block rounded" width="150" id="uploadedImage">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ ___('Short Description') }} *</label>
                            <textarea name="short_description" rows="2" class="form-control"
                                      placeholder="{{ ___('Maximum 150 characters') }}" required>{{ old('short_description') }}</textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">{{ ___('Content') }} *</label>
                            <textarea name="content" rows="10" class="form-control tiny-editor">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ ___('Language') }} *</label>
                            <select id="articleLang" name="lang" class="form-select" required>
                                <option value="" selected disabled>{{ ___('Choose') }}</option>
                                @foreach ($admin_languages as $adminLanguage)
                                    <option value="{{ $adminLanguage->code }}"
                                            @if (old('lang') == $adminLanguage->code) selected @endif>
                                        {{ $adminLanguage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">{{ ___('Category') }} *</label>
                            <select id="articleCategory" name="category" class="form-select" required>
                                <option value="" selected disabled>{{ ___('Choose') }}</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">{{ ___('Tags') }}</label>
                            <textarea name="tags" rows="2" class="form-control"
                                      placeholder="{{ ___('Enter tags separated by comma') }}" required>{{ old('tags') }}</textarea>
                        </div>
                        <button class="btn btn-primary">{{ ___('Submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('scripts_at_top')
        <script type="text/javascript">
            "use strict";
            var QuickMenu = {"page": "blog", "subpage": "blog-post"};
        </script>
    @endpush
    @push('scripts_vendor')
        <script src="{{ asset('admin/assets/plugins/tinymce/tinymce.min.js') }}"></script>
    @endpush
@endsection
