<!DOCTYPE html>
<html lang="{{ get_lang() }}">
<head>
    @include($activeTheme.'layouts.includes.head')
    @include($activeTheme.'layouts.includes.styles')
    {!! head_code() !!}
</head>
<body>
    @yield('content')

    @include($activeTheme.'layouts.includes.addons')
    @include($activeTheme.'layouts.includes.scripts')
    {!! google_captcha() !!}
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                Snackbar.show({
                    text: '{{ $error }}',
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#ee5252'
                });
            @endforeach
        </script>
    @elseif(session('status'))
        <script>
            Snackbar.show({
                text: '{{ session('status') }}',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#383838'
            });
        </script>
    @elseif(session('resent'))
        <script>
            Snackbar.show({
                text: '{{ ___('Link resend Successfully') }}',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#383838'
            });
        </script>
    @endif
</body>

</html>
