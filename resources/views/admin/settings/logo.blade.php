<div class="tab-pane" id="quick_logo_favicon">
    <form method="post" class="ajax_submit_form" data-action="{{ route('admin.settings.update') }}"
          data-ajax-sidepanel="true" enctype="multipart/form-data">

        <div class="quick-card card">
            <div class="card-header">
                <h5>{{ ___('Logo & Favicon') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ ___('Dark Logo') }}</label>
                            <div class="mb-3">
                                <div class="quick-imgview bg-light">
                                    <img id="dark_logo_img"
                                         src="{{ asset('storage/brand/'.$settings->media->dark_logo) }}">
                                </div>
                            </div>
                            <label for="dark_logo" class="btn btn-primary w-100 mb-2" tabindex="0">
                                <i class="fas fa-upload me-2"></i>
                                {{ ___('Upload New Image') }}
                                <input name="media[dark_logo]" type="file" id="dark_logo" hidden
                                       onchange="readURL(this,'dark_logo_img')"
                                       accept=".jpg, .jpeg, .png">
                            </label>
                            <small class="text-muted">{{ ___('Allowed JPG, JPEG or PNG.') }}</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ ___('Light Logo') }}</label>
                            <div class="mb-3">
                                <div class="quick-imgview bg-dark">
                                    <img id="light_logo_img"
                                         src="{{ asset('storage/brand/'.$settings->media->light_logo) }}">
                                </div>
                            </div>
                            <label for="light_logo" class="btn btn-primary w-100 mb-2" tabindex="0">
                                <i class="fas fa-upload me-2"></i>
                                {{ ___('Upload New Image') }}
                                <input name="media[light_logo]" type="file" id="light_logo" hidden
                                       onchange="readURL(this,'light_logo_img')"
                                       accept=".jpg, .jpeg, .png">
                            </label>
                            <small class="text-muted">{{ ___('Allowed JPG, JPEG or PNG.') }}</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ ___('Admin Logo') }}</label>
                            <div class="mb-3">
                                <div class="quick-imgview bg-light">
                                    <img id="admin_logo_img"
                                         src="{{ asset('storage/brand/'.$settings->media->admin_logo) }}">
                                </div>
                            </div>
                            <label for="admin_logo" class="btn btn-primary w-100 mb-2" tabindex="0">
                                <i class="fas fa-upload me-2"></i>
                                {{ ___('Upload New Image') }}
                                <input name="media[admin_logo]" type="file" id="admin_logo" hidden
                                       onchange="readURL(this,'admin_logo_img')"
                                       accept=".jpg, .jpeg, .png">
                            </label>
                            <small class="text-muted">{{ ___('Allowed JPG, JPEG or PNG.') }}</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ ___('Favicon') }}</label>
                            <div class="mb-3">
                                <div class="quick-imgview bg-light">
                                    <img id="favicon_img"
                                         src="{{ asset('storage/brand/'.$settings->media->favicon) }}">
                                </div>
                            </div>
                            <label for="favicon" class="btn btn-primary w-100 mb-2" tabindex="0">
                                <i class="fas fa-upload me-2"></i>
                                {{ ___('Upload New Image') }}
                                <input name="media[favicon]" type="file" id="favicon" hidden
                                       onchange="readURL(this,'favicon_img')"
                                       accept=".jpg, .jpeg, .png">
                            </label>
                            <small class="text-muted">{{ ___('Allowed JPG, JPEG or PNG.') }}</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ ___('Social Image') }}</label>
                            <div class="mb-3">
                                <div class="quick-img-card bg-light">
                                    <img id="social_image_img"
                                         src="{{ asset('storage/brand/'.$settings->media->social_image) }}"
                                         width="100%">
                                </div>
                            </div>
                            <label for="social_image" class="btn btn-primary w-100 mb-2" tabindex="0">
                                <i class="fas fa-upload me-2"></i>
                                {{ ___('Upload New Image') }}
                                <input name="media[social_image]" type="file" id="social_image" hidden
                                       onchange="readURL(this,'social_image_img')"
                                       accept="image/jpg, image/jpeg">
                            </label>
                            <small class="text-muted">
                                {{ ___('Allowed JPG or JPEG.') }} <strong>600x315px.</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="logo_setting" value="1">
                <button name="submit" type="submit" class="btn btn-primary">{{ ___('Save Changes') }}</button>
            </div>
        </div>
    </form>
</div>
