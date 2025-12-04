<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <title>@yield('title')</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:wght@300;400;500&display=swap" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        body {
            background: #fbfbfb;
            font-family: 'Poppins';
        }

        .mobile-wrapper {
            max-width: 430px;
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
        
        .input-auth {
        @apply w-full h-[52px] pl-5 border border-[#CFCFCF] rounded-xl
               text-[#2A2A2A] placeholder-[#CFCFCF]
               focus:outline-none focus:border-[#F26E21];
    }
    </style>

</head>

<body>

    <div class="mobile-wrapper @yield('wrapperClass')">
        @yield('content')
    </div>

</body>


</html>