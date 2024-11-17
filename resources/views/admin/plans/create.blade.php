<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{___('Add Plan')}}</h2>
            </div>
            <div class="slidePanel-actions">
                <button id="post_sidePanel_data" class="btn btn-icon btn-primary" title="{{___('Save')}}">
                    <i class="icon-feather-check"></i>
                </button>
                <button class="btn btn-icon btn-default slidePanel-close" title="{{___('Close')}}">
                    <i class="icon-feather-x"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="slidePanel-inner">
        <form action="{{ route('admin.plans.store') }}" method="post" enctype="multipart/form-data" id="sidePanel_form">
            @csrf
            <div class="mb-3 form-group">
                <label class="d-flex align-items-end m-b-5" for="name">
                    {{ ___('Plan Name') }} *
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
                    <input name="name" id="name" type="text" class="form-control" required value="" autofocus>
                </div>
                @foreach ($admin_languages as $language)
                    <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                        <input type="text" class="form-control" name="translations[{{ $language->code }}][name]">
                    </div>
                @endforeach
            </div>
            <div class="mb-3 form-group">
                <label class="d-flex align-items-end m-b-5">
                    {{ ___('Description') }}
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
                    <textarea name="description" class="form-control"></textarea>
                </div>
                @foreach ($admin_languages as $language)
                    <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                        <textarea name="translations[{{ $language->code }}][description]" class="form-control"></textarea>
                    </div>
                @endforeach
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Status') }} *</label>
                <select class="form-select" name="status">
                    <option value="1">{{ ___('Active') }}</option>
                    <option value="0">{{ ___('Inactive') }}</option>
                    <option value="2">{{ ___('Hidden') }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Monthly Price') }} *</label>
                <div class="custom-input-group input-group">
                    <input type="text" name="monthly_price" class="form-control"
                           value="0" required/>
                    <span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                </div>
                <small class="form-text">{{ ___('Set 0 to disable it.') }}</small>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Annual Price') }} *</label>
                <div class="custom-input-group input-group">
                    <input type="text" name="annual_price" class="form-control"
                           value="0" required/>
                    <span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                </div>
                <small class="form-text">{{ ___('Set 0 to disable it.') }}</small>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Lifetime Price') }} *</label>
                <div class="custom-input-group input-group">
                    <input type="text" name="lifetime_price" class="form-control"
                           value="0" required/>
                    <span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                </div>
                <small class="form-text">{{ ___('Set 0 to disable it.') }}</small>
            </div>
            <div class="mb-3">
                {{ quick_switch(___('Recommended'), 'recommended') }}
            </div>
            <h5 class="m-t-35">{{ ___('Plan Settings') }}</h5>
            <hr>
            <div class="mb-3">
                <label class="form-label" for="biopage_limit">{{ ___('Bio Pages Limit') }} *</label>
                <input name="biopage_limit" type="number" class="form-control" id="biopage_limit" value="1">
                <span class="form-text text-muted">{{ ___('Set -1 for unlimited.') }}</span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="biolink_limit">{{ ___('Links Limit') }} *</label>
                <input name="biolink_limit" type="number" class="form-control" id="biolink_limit" value="2">
                <span class="form-text text-muted">{{ ___('Number of links per bio page.'). ' '.___('Set -1 for unlimited.') }}</span>
            </div>
            <div class="mb-3">
                {{ quick_switch(___('Hide Branding'), 'hide_branding', true) }}
            </div>
            <div class="mb-3">
                {{ quick_switch(___('Show advertisements'), 'advertisements') }}
            </div>

            @if($PlanOption->count())
                <h5 class="m-t-35">{{ ___('Custom Settings') }}</h5>
                <hr>
                @foreach ($PlanOption as $planoption)
                    {{quick_switch($planoption['title'], "planoptions[{$planoption['id']}]")}}
                @endforeach
            @endif
        </form>
    </div>
</div>
