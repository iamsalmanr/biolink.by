<div class="tab-pane" id="quick_blog">
    <form class="ajax_submit_form" data-action="{{ route('admin.settings.update') }}" method="POST">
        <div class="card">
            <div class="card-header">
                <h5>{{ ___('Blog Settings') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            {{quick_switch(___('Blog'), 'blog[status]', @$settings->blog->status == '1')}}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            {{quick_switch(___('Show Blog On Home Page'), 'blog[show_on_home]', @$settings->blog->show_on_home == '1')}}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            {{ quick_switch(___('Blog Commenting'), 'blog[commenting]', @$settings->blog->commenting == '1')}}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="blog_page_limit">{{___('Number of Blogs on blog page')}}</label>
                            <input name="blog[page_limit]" id="blog_page_limit" type="number" class="form-control" value="{{$settings->blog->page_limit ?? 8}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="blog_settings" value="1">
                <button type="submit" class="btn btn-primary">{{ ___('Save Changes') }}</button>
            </div>
        </div>
    </form>
</div>
