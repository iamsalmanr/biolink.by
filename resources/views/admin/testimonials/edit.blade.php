<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Edit Testimonial') }}</h2>
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
        <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="post" id="sidePanel_form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ ___('Image') }}</label>
                <div class="d-flex align-items-center gap-4">
                    <img src="{{ asset('storage/testimonials/'.$testimonial->image) }}" alt=""
                         class="d-block rounded" width="90" id="uploadedImage">
                    <div>
                        <label for="upload" class="btn btn-primary mb-2" tabindex="0">
                            <i class="fas fa-upload"></i>
                            <span class="d-none d-sm-block ms-2">{{ ___('Upload Image') }}</span>
                            <input name="image" type="file" id="upload" hidden
                                   onchange="readURL(this,'uploadedImage')"
                                   accept="image/png, image/jpeg" required>
                        </label>
                        <p class="form-text mb-0">{{ ___('Allowed JPG, JPEG or PNG.') }}</p>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Name') }} *</label>
                <input type="name" class="form-control" name="name" value="{{ $testimonial->name }}"
                       required>
            </div>

            <div class="mb-3 form-group">
                <label class="d-flex align-items-end m-b-5" for="designation">
                    {{ ___('Designation') }} *
                    <div class="d-flex align-items-center translate-picker">
                        <i class="fa fa-language"></i>
                        <select class="custom-select custom-select-sm ml-1">
                            <option value="default">{{ ___('Default') }}</option>
                            @foreach ($admin_languages as $language)
                                <option value="{{ $language->code }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </label>
                <div class="translate-fields translate-fields-default">
                    <input name="designation" id="designation" type="text" class="form-control" required value="{{ $testimonial->designation }}" placeholder="{{ ___('Designation') }}" autofocus>
                </div>
                @foreach ($admin_languages as $language)
                    <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                        <input type="text" class="form-control" name="translations[{{ $language->code }}][designation]" placeholder="{{ ___('Designation') }}" value="{{ !empty($testimonial->translations->{$language->code}->designation)
                        ? $testimonial->translations->{$language->code}->designation
                        : $testimonial->designation }}">
                    </div>
                @endforeach
            </div>
            <div class="mb-3 form-group">
                <label class="d-flex align-items-end m-b-5" for="content">
                    {{ ___('Content') }} *
                    <div class="d-flex align-items-center translate-picker">
                        <i class="fa fa-language"></i>
                        <select class="custom-select custom-select-sm ml-1">
                            <option value="default">{{ ___('Default') }}</option>
                            @foreach ($admin_languages as $language)
                                <option value="{{ $language->code }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </label>
                <div class="translate-fields translate-fields-default">
                    <textarea name="content" rows="4" class="form-control" required>{{ $testimonial->content }}</textarea>
                </div>
                @foreach ($admin_languages as $language)
                    <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                        <textarea name="translations[{{ $language->code }}][content]" rows="4" class="form-control" required>{{ !empty($testimonial->translations->{$language->code}->content)
                        ? $testimonial->translations->{$language->code}->content
                        : $testimonial->content }}</textarea>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
</div>
<script>
    // translate picker
    $(document).off('change', ".translate-picker select").on('change', ".translate-picker select", function (e) {
        $('.translate-fields').hide();
        $('.translate-fields-' + $(this).val()).show();
        $('.translate-picker select').val($(this).val());
    });
</script>
