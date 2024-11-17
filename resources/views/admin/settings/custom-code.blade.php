<div class="tab-pane" id="quick_custom_code">
    <form method="post" class="ajax_submit_form" data-action="{{ route('admin.settings.update') }}" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5>{{ ___('Custom CSS') }}</h5>
            </div>
            <div class="card-body">
                <div>
                    <textarea name="custom_css" id="custom_css" class="form-control" rows="5">{{ @$settings->custom_css }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="custom_code_setting" value="1">
                <button name="submit" type="submit" class="btn btn-primary">{{ ___('Save Changes') }}</button>
            </div>
        </div>
    </form>
</div>
@push('styles_vendor')
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/codemirror/codemirror.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/codemirror/monokai.min.css') }}">
@endpush
@push('scripts_vendor')
    <script src="{{ asset('admin/assets/plugins/codemirror/codemirror.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/codemirror/css.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/codemirror/sublime.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/codemirror/autorefresh.js') }}"></script>
@endpush
@push('scripts_at_bottom')
    <script>
        $(function() {
            var element = document.getElementById("custom_css");
            var editor = CodeMirror.fromTextArea(element, {
                lineNumbers: true,
                mode: "text/css",
                theme: "monokai",
                keyMap: "sublime",
                autoCloseBrackets: true,
                matchBrackets: true,
                showCursorWhenSelecting: true,
                autoRefresh:true,
            });
        });
    </script>
@endpush
