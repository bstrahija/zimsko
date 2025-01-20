<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zimsko Košarkaško Prvenstvo Čakovec</title>

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link href="{{ asset('img/favicon/favicon.ico') }}" rel="shortcut icon" type="image/vnd.microsoft.icon" />

    <meta name="app-url" content="{{ url('/') }}">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">

    <meta name="author" content="Boris Strahija, Creo">
    <meta name="copyright" content="Zimsko Košarkaško Prvenstvo Čakovec">
    <meta name="application-name" content="Zimsko Košarkaško Prvenstvo Čakovec">
    <meta name="description"
        content="ZIMSKO KOŠARKAŠKO PRVENSTVO“Zimsko košarkaško prvenstvo” je zamišljeno kao amatersko prvenstvo u košarci koje se odigrava nedjeljom u jutarnjim satima">
    <meta name="keywords" content="zimsko, zima, košarka, prvenstvo, čakovec, međimurje, basketball">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Zimsko">
    <meta name="apple-mobile-web-app-title" content="Zimsko Košarkaško Prvenstvo Čakovec">
    <meta name="msapplication-navbutton-color" content="#ffffff">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link rel="apple-touch-icon" sizes="57x57" href="https://zimsko.com/wp-content/themes/basket/assets/images/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://zimsko.com/wp-content/themes/basket/assets/images/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://zimsko.com/wp-content/themes/basket/assets/images/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://zimsko.com/wp-content/themes/basket/assets/images/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="https://zimsko.com/wp-content/themes/basket/assets/images/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://zimsko.com/wp-content/themes/basket/assets/images/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="https://zimsko.com/wp-content/themes/basket/assets/images/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://zimsko.com/wp-content/themes/basket/assets/images/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://zimsko.com/wp-content/themes/basket/assets/images/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="https://zimsko.com/wp-content/themes/basket/assets/images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://zimsko.com/wp-content/themes/basket/assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="https://zimsko.com/wp-content/themes/basket/assets/images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://zimsko.com/wp-content/themes/basket/assets/images/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#111">
    <meta name="msapplication-TileImage" content="https://zimsko.com/wp-content/themes/basket/assets/images/ms-icon-144x144.png">
    <meta name="theme-color" content="#111">

    <meta name="robots" content="max-snippet:-1,max-image-preview:standard,max-video-preview:-1" />
    <link rel="canonical" href="https://zimsko.com/" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="hr_HR" />
    <meta property="og:site_name" content="Zimsko Košarkaško Prvenstvo Čakovec" />
    <meta property="og:title" content="Zimsko Košarkaško Prvenstvo Čakovec" />
    <meta property="og:description"
        content="&ldquo;Zimsko ko&scaron;arka&scaron;ko prvenstvo&rdquo; je zami&scaron;ljeno kao amatersko prvenstvo u ko&scaron;arci koje se odigrava nedjeljom u jutarnjim satima, a traje kroz siječanj, veljaču i ožujak." />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('img/logo_ice.png') }}" />
    <meta property="og:image:width" content="2000" />
    <meta property="og:image:height" content="1414" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Zimsko Košarkaško Prvenstvo Čakovec" />
    <meta name="twitter:description"
        content="&ldquo;Zimsko ko&scaron;arka&scaron;ko prvenstvo&rdquo; je zami&scaron;ljeno kao amatersko prvenstvo u ko&scaron;arci koje se odigrava nedjeljom u jutarnjim satima, a traje kroz siječanj, veljaču i ožujak." />
    <meta name="twitter:image" content="{{ asset('img/logo_ice.png') }}" />

    <script defer src="https://cloud.umami.is/script.js" data-website-id="efe2fff4-3192-4870-9a3a-d56d04f56341"></script>

    @vite(['resources/js/app.js'])
</head>

<body class="bg-slate-100">
    <div class="relative z-10 app" id="app">
        <x-navigation.main />

        @yield('content')

        <div class="wrapper">
            <hr class="my-12">

            <x-sponsors />
        </div>

        <x-footer />
    </div>

    {{-- <div class="fixed inset-0 z-0 opacity-20 bg"></div>
 --}}
</body>

</html>
