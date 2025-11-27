<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <title>@yield('title')</title>

    @vite('resources/css/app.css')

    <style>
        body {
            background: #fbfbfb;
            font-family: 'Inter', sans-serif;
        }

        .mobile-wrapper {
            max-width: 430px;
            height: 932px;
            margin: 0 auto;
            background: #FBFBFB;
            padding: 32px 24px;
        }

        input {
            height: 52px;
        }

        /* REMOVE PADDING KHUSUS ONBOARDING */
        .onboarding-wrapper {
            padding: 0 !important;
        }
    </style>

</head>

<body>

    <div class="mobile-wrapper @yield('wrapperClass')">
        @yield('content')
    </div>

</body>

</html>