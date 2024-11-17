@if(demo_mode())
    <script>
        if(window.location !== window.parent.location){ window.top.location.href = window.location; }
    </script>
    <style>
        .demo-frame-wrapper {
            min-height: 4rem;
            background: #161A38;
            padding: .5rem 1rem;
            display: flex;
            flex-direction: column;
            font-size: .85rem;
        }

        .demo-frame-link {
            color: white;
            display: flex;
            align-items: center;
            margin-bottom: .5rem;
            align-self: center;
        }

        .demo-frame-link:hover {
            text-decoration: none;
            color: white;
        }

        .demo-frame-logo {
            width: 8rem;
            height: auto;
            margin-right: 1rem;
        }

        .demo-frame-btn-primary {
            padding: 0.25rem 1.25rem;
            background: #6366f1;
            color: white;
            border-radius: 0.25rem;
            transition: background .3s linear !important;
            white-space: nowrap;
            font-weight: 500;
        }

        .demo-frame-btn-primary:hover {
            text-decoration: none;
            background: #7a7df3;
            color: white;
            transition: background .3s linear !important;
        }

        .demo-frame-btn-secondary {
            padding: .25rem 0;
            color: #fff;
            border-radius: .25rem;
            transition: all .3s linear !important;
            white-space: nowrap;
            margin-right: 1.25rem;
        }

        .demo-frame-btn-secondary:hover {
            text-decoration: none;
            color: #bbb;
        }

        .demo-frame-actions {
            display: flex;
            justify-content: space-around;
        }

        @media (min-width: 992px) {
            .demo-frame-wrapper {
                justify-content: space-between;
                align-items: center;
                flex-direction: row;
                min-height: 3rem;
                padding: .5rem 2rem;
            }

            .demo-frame-link {
                margin-bottom: 0;
            }

            .demo-frame-actions {
                justify-content: initial;
            }
        }
    </style>
    <div class="demo-frame-wrapper">
        <a href="https://bylancer.com/" target="_blank" class="demo-frame-link">
            <img src="https://bylancer.com/storage/logo/classic-theme_logo.png" alt="Bylancer" class="demo-frame-logo">
        </a>
        <div class="demo-frame-actions">
            <a href="https://bylancer.ticksy.com/" target="_blank" class="demo-frame-btn-secondary"><i
                    class="fas fa-headset"></i> Help Center</a>
            @if(!empty(config('appinfo.buy_now_url')))
                <a href="{{config('appinfo.buy_now_url')}}" class="demo-frame-btn-primary"><i
                        class="fas fa-shopping-cart"></i> Buy Now</a>
            @endif
        </div>
    </div>
@endif
