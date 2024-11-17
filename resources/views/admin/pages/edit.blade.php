<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Edit Page') }}</h2>
            </div>
            <div class="slidePanel-actions">
                <button id="post_sidePanel_data" class="btn btn-icon btn-primary" title="{{ ___('Save') }}">
                    <i class="icon-feather-check"></i>
                </button>
                <button class="btn btn-default btn-icon slidePanel-close" title="{{ ___('Close') }}">
                    <i class="icon-feather-x"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="slidePanel-inner">
        <form action="{{ route('admin.pages.update', $page->id) }}" method="post" id="sidePanel_form">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ ___('Title') }} *</label>
                <input type="text" name="title" class="form-control" required
                       value="{{ $page->title }}" />
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Slug') }}</label>
                <input type="text" name="slug" class="form-control"
                       value="{{ $page->slug }}" />
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Language') }} *</label>
                <select name="lang" class="form-select" required>
                    <option value="" selected disabled>{{ ___('Choose') }}</option>
                    @foreach ($admin_languages as $adminLanguage)
                        <option value="{{ $adminLanguage->code }}"
                                @if ($page->lang == $adminLanguage->code) selected @endif>
                            {{ $adminLanguage->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Short description') }} *</label>
                <textarea name="short_description" rows="3" class="form-control" required>{{ $page->short_description }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Content') }} *</label>
                <textarea name="content" rows="10" class="form-control tiny-editor">{{ $page->content }}</textarea>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('admin/assets/js/quicklara.js') }}"></script>
