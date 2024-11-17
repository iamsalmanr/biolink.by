<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{___('Edit Plan')}}</h2>
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
        <form action="{{ route('admin.plans.update', $plan->id) }}" method="post" enctype="multipart/form-data"
              id="sidePanel_form">
            @csrf
            @method('PUT')

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
                    <input name="name" id="name" type="text" class="form-control" required value="{{ $plan->name }}"
                           autofocus>
                </div>
                @foreach ($admin_languages as $language)
                    <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                        <input type="text" class="form-control" name="translations[{{ $language->code }}][name]" value="{{ !empty($plan->translations->{$language->code}->name)
                        ? $plan->translations->{$language->code}->name
                        : $plan->name }}">
                    </div>
                @endforeach
            </div>
            <div class="mb-3 form-group">
                <label class="d-flex align-items-end m-b-5" for="name">
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
                    <textarea name="description" class="form-control"
                              required>{{ $plan->description }}</textarea>
                </div>
                @foreach ($admin_languages as $language)
                    <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                        <textarea name="translations[{{ $language->code }}][description]" class="form-control"
                                  required>{{ !empty($plan->translations->{$language->code}->description)
                        ? $plan->translations->{$language->code}->description
                        : $plan->description }}</textarea>
                    </div>
                @endforeach
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Status') }} *</label>
                <select class="form-select" name="status">
                    <option value="1" {{$plan->status == 1 ? 'selected' : ''}}>{{ ___('Active') }}</option>
                    <option value="0" {{$plan->status == 0 ? 'selected' : ''}}>{{ ___('Inactive') }}</option>
                    <option value="2" {{$plan->status == 2 ? 'selected' : ''}}>{{ ___('Hidden') }}</option>
                </select>
            </div>

            @if($plan->id != 'free' && $plan->id != 'trial')
                <div class="mb-3">
                    <label class="form-label">{{ ___('Monthly Price') }} *</label>
                    <div class="custom-input-group input-group">
                        <input type="text" name="monthly_price" class="form-control"
                               value="{{ $plan->monthly_price }}" required/>
                        <span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                    </div>
                    <small class="form-text">{{ ___('Set 0 to disable it.') }}</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ ___('Annual Price') }} *</label>
                    <div class="custom-input-group input-group">
                        <input type="text" name="annual_price" class="form-control"
                               value="{{ $plan->annual_price }}" required/>
                        <span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                    </div>
                    <small class="form-text">{{ ___('Set 0 to disable it.') }}</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ ___('Lifetime Price') }} *</label>
                    <div class="custom-input-group input-group">
                        <input type="text" name="lifetime_price" class="form-control"
                               value="{{ $plan->lifetime_price }}" required/>
                        <span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                    </div>
                    <small class="form-text">{{ ___('Set 0 to disable it.') }}</small>
                </div>
                <div class="mb-3">
                    {{ quick_switch(___('Recommended'), 'recommended', $plan->recommended == '1') }}
                </div>
            @endif

            @if ($plan->id  == 'trial')
                <div class="mb-3">
                    <label class="form-label" for="days">{{ ___('Days') }} *</label>
                    <input name="days" type="number" class="form-control" id="days"
                           value="{{ $plan->days }}" min="1">
                    <span
                        class="form-text text-muted">{{ ___('The number of days, the trial plan can be used.') }}</span>
                </div>
            @endif

            <h5 class="m-t-35">{{ ___('Plan Settings') }}</h5>
            <hr>
            <div class="mb-3">
                <label class="form-label" for="biopage_limit">{{ ___('Bio Pages Limit') }} *</label>
                <input name="biopage_limit" type="number" class="form-control" id="biopage_limit"
                       value="{{ $plan->settings->biopage_limit }}">
                <span class="form-text text-muted">{{ ___('Set -1 for unlimited.') }}</span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="biolink_limit">{{ ___('Links Limit') }} *</label>
                <input name="biolink_limit" type="number" class="form-control" id="biolink_limit"
                       value="{{ $plan->settings->biolink_limit }}">
                <span
                    class="form-text text-muted">{{ ___('Number of links per bio page.'). ' '.___('Set -1 for unlimited.') }}</span>
            </div>
            <div class="mb-3">
                {{ quick_switch(___('Hide Branding'), 'hide_branding', $plan->settings->hide_branding == '1') }}
            </div>
            <div class="mb-3">
                {{quick_switch(___('Show advertisements'), 'advertisements', $plan->settings->advertisements == '1')}}
            </div>

            @if($PlanOption->count())
                <h5 class="m-t-35">{{ ___('Custom Settings') }}</h5>
                <hr>
                @foreach ($PlanOption as $planoption)
                    @php
                        $planoption_id = $planoption['id'];
                    @endphp

                    {{ quick_switch($planoption['title'], "planoptions[$planoption_id]", (isset($plan->settings->custom_features->$planoption_id) && $plan->settings->custom_features->$planoption_id == '1')) }}

                @endforeach
            @endif
        </form>
    </div>
</div>
