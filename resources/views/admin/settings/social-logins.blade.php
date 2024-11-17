<div class="tab-pane" id="quick_social_logins">
    <form class="ajax_submit_form" data-action="{{ route('admin.settings.update') }}" method="POST">
        <div class="card">
            <div class="card-header">
                <h5>{{ ___('Social Logins') }}</h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="accordions">

                    <div class="card accordion-item mb-3">
                        <h2 class="accordion-header" id="heading_facebook">
                            <button type="button" class="accordion-button fw-semibold collapsed" data-bs-toggle="collapse" data-bs-target="#facebook" aria-expanded="false" aria-controls="facebook">
                                {{ ___('Facebook') }}
                            </button>
                        </h2>

                        <div id="facebook" class="accordion-collapse collapse" data-bs-parent="#accordions" style="">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    {{quick_switch(___('Status'), 'facebook_login[status]', @$settings->facebook_login->status == '1')}}
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ ___('Facebook App Id') }} </label>
                                            <input type="text" name="facebook_login[app_id]" class="form-control"
                                                   value="{{ demo_mode() ? '' : @$settings->facebook_login->app_id }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ ___('Facebook App Secret') }} </label>
                                            <input type="text" name="facebook_login[app_secret]" class="form-control"
                                                   value="{{ demo_mode() ? '' : @$settings->facebook_login->app_secret }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">{{ ___('Facebook Callback Url') }} </label>
                                            <input type="text" class="form-control"
                                                   value="{{ url('/').'/auth/facebook/callback' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card accordion-item mb-3">
                        <h2 class="accordion-header" id="heading_google">
                            <button type="button" class="accordion-button fw-semibold collapsed" data-bs-toggle="collapse" data-bs-target="#google" aria-expanded="false" aria-controls="google">
                                {{ ___('Google') }}
                            </button>
                        </h2>

                        <div id="google" class="accordion-collapse collapse" data-bs-parent="#accordions" style="">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    {{quick_switch(___('Status'), 'google_login[status]', @$settings->google_login->status == '1')}}
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ ___('Google Client Id') }} </label>
                                            <input type="text" name="google_login[client_id]" class="form-control"
                                                   value="{{ demo_mode() ? '' : @$settings->google_login->client_id }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ ___('Google Client Secret') }} </label>
                                            <input type="text" name="google_login[client_secret]" class="form-control"
                                                   value="{{ demo_mode() ? '' : @$settings->google_login->client_secret }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">{{ ___('Google Callback Url') }} </label>
                                            <input type="text" class="form-control"
                                                   value="{{ url('/').'/auth/google/callback' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="social_logins_settings" value="1">
                <button type="submit" class="btn btn-primary">{{ ___('Save Changes') }}</button>
            </div>
        </div>
    </form>
</div>
