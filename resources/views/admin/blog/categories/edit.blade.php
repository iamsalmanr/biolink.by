<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Edit Category') }}</h2>
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
        <form action="{{ route('admin.categories.update', $category->id) }}" method="post" id="sidePanel_form">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ ___('Language') }} *</label>
                <select name="lang" class="form-select select2" required>
                    <option value="" selected disabled>{{ ___('Choose') }}</option>
                    @foreach ($admin_languages as $adminLanguage)
                        <option value="{{ $adminLanguage->code }}"
                                @if ($category->lang == $adminLanguage->code) selected @endif>
                            {{ $adminLanguage->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Category name') }} *</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}"
                       required />
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Slug') }}</label>
                <input type="text" name="slug" class="form-control" value="{{ $category->slug }}"
                       required />
            </div>
        </form>
    </div>
</div>
