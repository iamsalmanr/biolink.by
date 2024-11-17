
{{-- Cookie consent box --}}
@if(@$settings->enable_cookie_consent_box && !isset($_COOKIE['quick_cookie_accepted']))
<div class="cookieConsentContainer">
    <div class="cookieTitle">
        <h3>{{ ___('Cookies') }}</h3>
    </div>
    <div class="cookieDesc">
        <p>{{ ___('This website uses cookies to ensure you get the best experience on our website.') }}
            @if(!empty($settings->cookie_policy_link))
            <a class="text-primary" href="{{$settings->cookie_policy_link}}">{{ ___('Cookie Policy') }}</a>
            @endif
        </p>
    </div>
    <div class="cookieButton">
        <a href="javascript:void(0)" class="button -primary cookieAcceptButton">{{ ___('Accept') }}</a>
    </div>
</div>
@endif

{{-- Google analytics --}}
@if(@$settings->google_analytics->status && !empty($settings->google_analytics->measurement_id))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$settings->google_analytics->measurement_id}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag("js", new Date());
        gtag("config", "{{$settings->google_analytics->measurement_id}}");
    </script>
@endif

{{-- Tawk.to --}}
@if(@$settings->tawk_to->status && !empty($settings->tawk_to->chat_link))
    @php
        $chat_link = $settings->tawk_to->chat_link;
        $chat_link = str_replace('https://tawk.to/chat/', '', $chat_link);

        $user_data = '';
        if(auth()->check() && $user = request()->user()){
            $user_data = "Tawk_API.visitor = {
                name: ".json_encode($user->name) .",
                email: ".json_encode($user->email) ."
            };";
        }
    @endphp

    <script type='text/javascript'>
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        {!! $user_data !!}
        (function(){
            var s1=document.createElement('script'),s0=document.getElementsByTagName('script')[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/{!! $chat_link !!}';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
@endif
