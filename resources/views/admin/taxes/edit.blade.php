<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Edit tax') }}</h2>
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
        <form action="{{ route('admin.taxes.update', $tax->id) }}" method="post" id="sidePanel_form">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ ___('Title') }} *</label>
                <input type="text" value="{{$tax->title}}" name="title" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Description') }} *</label>
                <input type="text" value="{{$tax->description}}" name="description" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Country') }} *</label>
                <select name="country_id" class="form-select select2" required>
                    <option></option>
                    <option value="0" {{ !$tax->country_id ? 'selected' : '' }}>
                        {{ ___('All countries') }}
                    </option>
                    @foreach (countries() as $country)
                        <option value="{{ $country->id }}" @if ($tax->country_id == $country->id) selected @endif>
                            {{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Tax percentage') }} *</label>
                <div class="input-group">
                    <input type="number" name="percentage" class="form-control" placeholder="0"
                           value="{{ $tax->percentage }}" required>
                    <span class="input-group-text"><i class="icon-feather-percent"></i></span>
                </div>
            </div>
        </form>
    </div>
</div>
