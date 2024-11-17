<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Add language') }}</h2>
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
        <form action="{{ route('admin.languages.store') }}" method="post" id="sidePanel_form" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-start justify-content-between gap-4">
                <div>
                    <label for="upload" class="btn btn-primary mb-2" tabindex="0">
                        <i class="fas fa-upload"></i>
                        <span class="d-none d-sm-block ms-2">{{ ___('Upload Flag') }}</span>
                        <input name="flag" type="file" id="upload" hidden
                               onchange="readURL(this,'uploadedFlag')"
                               accept="image/png, image/jpeg">
                    </label>
                    <p class="form-text mb-0">{{ ___('Allowed JPG, JPEG or PNG.') }}</p>
                </div>
                <img src="" alt=""
                     class="d-block rounded" height="50" id="uploadedFlag">
            </div>
            <hr>
            <div class="mb-3">
                <label class="form-label">{{ ___('Name') }} : <span class="red">*</span></label>
                <input type="text" name="name" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Code') }} (ISO 639 Set 1) <span class="red">*</span></label>
                <input type="text" name="code" class="form-control" required>
                <small class="form-text"><a href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" target="_blank">https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes</a></small>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Direction') }} : <span class="red">*</span></label>
                <select name="direction" class="form-control">
                    <option value="1">{{ ___('LTR') }}</option>
                    <option value="2">{{ ___('RTL') }}</option>
                </select>
            </div>
            <div class="mb-3">
                {{quick_switch(___('Set Default language'), 'is_default')}}
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('admin/assets/js/quicklara.js') }}"></script>
