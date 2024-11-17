<script type="text/javascript">
    "use strict";
    const BASE_URL = "{{ url(admin_url()) }}";
    const PRIMARY_COLOR = "{{ $settings->colors->primary_color }}";
</script>
@stack('scripts_at_top')
<script src="{{ asset('global/js/jquery.min.js') }}"></script>
<script src="{{ asset('global/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('admin/assets/js/tippy.all.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery-slidePanel.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/sidePanel.js') }}"></script>
<script src="{{ asset('admin/assets/js/select2.full.min.js') }}"></script>
<script src="{{ asset('global/js/jquery.form.js') }}"></script>

<script src="{{ asset('admin/assets/js/clipboard.min.js') }}"></script>

<script src="{{ asset('admin/assets/js/helpers.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('admin/assets/js/menu.js') }}"></script>
<script src="{{ asset('admin/assets/js/main.js') }}"></script>
@stack('scripts_vendor')
<script src="{{ asset('admin/assets/js/admin-ajax.js') }}"></script>
<script src="{{ asset('admin/assets/js/script.js') }}"></script>
<script src="{{ asset('admin/assets/js/quicklara.js') }}"></script>

@stack('scripts_at_bottom')

@if(\Session::has('quick_alert_message'))
    <script>
        quick_alert(@json(\Session::get('quick_alert_message')), '{{ \Session::get('quick_alert_type') }}')
    </script>
@endif
