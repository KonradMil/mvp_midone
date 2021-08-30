<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DBR77 Platform</title>

    <!-- Scripts -->
    <script src="https://unpkg.com/vue@next"></script>
    <script type="module" src="https://cdn.skypack.dev/@headlessui/vue"></script>
    <script  src="https://cdn.jsdelivr.net/npm/@vue-hero-icons/solid@1.7.2/lib/index.cjs.min.js"></script>
    <script  src="https://cdn.jsdelivr.net/npm/@vue-hero-icons/outline"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {

            font-family: 'Nunito Sans', sans-serif;
        }

        .navbar-light .navbar-nav .nav-link {
            text-transform: uppercase;
            font-weight: bold;
            color: #3a2a68 !important;
            -webkit-transition: background-color 2s; /* For Safari 3.1 to 6.0 */
            transition: background-color 1s;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            background-color: #3a2a68;
            color: #fff !important;
        }

        footer {
            /*position: absolute;*/
            /*width: 100%;*/
            /*bottom: 0;*/
            background: linear-gradient(270deg, #3a2a68, #8787ff);
            background-size: 400% 400%;

            -webkit-animation: gradientFooter 20s ease infinite;
            -moz-animation: gradientFooter 20s ease infinite;
            -o-animation: gradientFooter 20s ease infinite;
            animation: gradientFooter 20s ease infinite;
        }
        @-webkit-keyframes gradientFooter {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        @-moz-keyframes gradientFooter {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        @-o-keyframes gradientFooter {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        @keyframes gradientFooter {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }

        @-webkit-keyframes swing
        {
            15%
            {
                -webkit-transform: translateX(5px);
                transform: translateX(5px);
            }
            30%
            {
                -webkit-transform: translateX(-5px);
                transform: translateX(-5px);
            }
            50%
            {
                -webkit-transform: translateX(3px);
                transform: translateX(3px);
            }
            65%
            {
                -webkit-transform: translateX(-3px);
                transform: translateX(-3px);
            }
            80%
            {
                -webkit-transform: translateX(2px);
                transform: translateX(2px);
            }
            100%
            {
                -webkit-transform: translateX(0);
                transform: translateX(0);
            }
        }
        @keyframes swing
        {
            15%
            {
                -webkit-transform: translateX(5px);
                transform: translateX(5px);
            }
            30%
            {
                -webkit-transform: translateX(-5px);
                transform: translateX(-5px);
            }
            50%
            {
                -webkit-transform: translateX(3px);
                transform: translateX(3px);
            }
            65%
            {
                -webkit-transform: translateX(-3px);
                transform: translateX(-3px);
            }
            80%
            {
                -webkit-transform: translateX(2px);
                transform: translateX(2px);
            }
            100%
            {
                -webkit-transform: translateX(0);
                transform: translateX(0);
            }
        }
        .bottom-menu li {
            float: left;
            color: white;
            margin-left: 50px;
        }
        .bottom-menu li a{
            color: #fff;
            font-weight: bold;
            /*text-transform: uppercase;*/
        }
        .bottom-menu {
            margin-top: 60px;
            list-style: none;
        }
    </style>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,900&display=swap&subset=latin-ext" rel="stylesheet">

    <!-- Styles -->
    @yield('styles')
</head>
<body style="margin: 0 !important; padding: 0 !important;">
<div id="app">
   <x-top-menu></x-top-menu>
        @yield('content')
    <x-footer></x-footer>
</div>

<!-- Footer -->
@yield('scripts')
<script>
    // import {Popover, PopoverButton, PopoverGroup, PopoverPanel} from 'https://cdn.skypack.dev/@headlessui/vue';
    const solutions = [
        {
            name: 'Analytics',
            description: 'Get a better understanding of where your traffic is coming from.',
            href: '#',
            icon: ChartBarIcon,
        },
        {
            name: 'Engagement',
            description: 'Speak directly to your customers in a more meaningful way.',
            href: '#',
            icon: CursorClickIcon,
        },
        { name: 'Security', description: "Your customers' data will be safe and secure.", href: '#', icon: ShieldCheckIcon },
        {
            name: 'Integrations',
            description: "Connect with third-party tools that you're already using.",
            href: '#',
            icon: ViewGridIcon,
        },
        {
            name: 'Automations',
            description: 'Build strategic funnels that will drive your customers to convert',
            href: '#',
            icon: RefreshIcon,
        },
    ]
    const callsToAction = [
        { name: 'Watch Demo', href: '#', icon: PlayIcon },
        { name: 'Contact Sales', href: '#', icon: PhoneIcon },
    ]
    const resources = [
        {
            name: 'Help Center',
            description: 'Get all of your questions answered in our forums or contact support.',
            href: '#',
            icon: SupportIcon,
        },
        {
            name: 'Guides',
            description: 'Learn how to maximize our platform to get the most out of it.',
            href: '#',
            icon: BookmarkAltIcon,
        },
        {
            name: 'Events',
            description: 'See what meet-ups and other events we might be planning near you.',
            href: '#',
            icon: CalendarIcon,
        },
        { name: 'Security', description: 'Understand how we take your privacy seriously.', href: '#', icon: ShieldCheckIcon },
    ]
    const recentPosts = [
        { id: 1, name: 'Boost your conversion rate', href: '#' },
        { id: 2, name: 'How to use search engine optimization to drive traffic to your site', href: '#' },
        { id: 3, name: 'Improve your customer experience', href: '#' },
    ];

    const app = new Vue({
        el: '#app',
        components: {
            Popover,
            PopoverButton,
            PopoverGroup,
            PopoverPanel,
            ChevronDownIcon,
            MenuIcon,
            XIcon,
        },
        setup() {
            onMounted(() => {
                cash("body").addClass("main-site");

            });
            return {
                solutions,
                callsToAction,
                resources,
                recentPosts,
            }
        }
    });

</script>
</body>
</html>
