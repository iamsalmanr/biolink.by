<div class="tab-pane" id="quick_colors">
    <form method="post" class="ajax_submit_form" data-action="{{ route('admin.settings.update') }}" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5>{{ ___('Colors') }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ ___('Primary Color') }} *</label>
                        <input type="color" name="colors[primary_color]" class="form-control form-control-lg"
                               value="{{ $settings->colors->primary_color }}" required>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="colors_setting" value="1">
                <button name="submit" type="submit" class="btn btn-primary">{{ ___('Save Changes') }}</button>
            </div>
        </div>
    </form>
</div>
