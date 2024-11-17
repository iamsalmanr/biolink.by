@stack('scripts_at_top')
<script>
    "use strict";
    const lang = {
        are_you_sure: @json(___('Are you sure?')),
    };
</script>
<script src="{{ asset('global/js/jquery.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('global/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('global/js/jquery.form.js') }}"></script>
<!--Plugin JS-->
<script src="{{ asset($activeThemeAssets.'assets/plugin/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/plugin/owl-carousel/carousel-thumbs.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/plugin/magnific-poupup/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/plugin/mixitup/mixitup.min.js') }}"></script><!--for sorting filter-->
<script src="{{ asset($activeThemeAssets.'assets/plugin/chartJS/Chart.bundle.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/plugin/simple-bar/simplebar.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/plugin/appear/appear.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/plugin/text-typer/typing-text.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/plugin/wow-animate/wow.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/plugin/svginject.min.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/plugin/snackbar/snackbar.min.js') }}"></script>
@stack('scripts_vendor')
<!--Custom JS-->
<script src="{{ asset($activeThemeAssets.'assets/js/custom.js') }}"></script>
<script src="{{ asset($activeThemeAssets.'assets/js/script.js') }}"></script>

@stack('scripts_at_bottom')

@if(\Session::has('quick_alert_message'))
    <script>
        Snackbar.show({
            text: @json(\Session::get('quick_alert_message')),
            pos: 'bottom-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 3000,
            textColor: '#fff',

            @if(\Session::get('quick_alert_type') == 'error')
            backgroundColor: '#ee5252'
            @elseif(\Session::get('quick_alert_type') == 'success')
            backgroundColor: '#383838'
            @elseif(\Session::get('quick_alert_type') == 'info')
            backgroundColor: '#45cfe1'
            @endif
        });
    </script>
@endif
