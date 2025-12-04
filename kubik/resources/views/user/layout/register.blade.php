<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite('resources/css/app.css')

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #fbfbfb;
            font-family: 'Poppins', sans-serif;
        }

        .register-wrapper {
            max-width: 430px;
            margin: 0 auto;
            min-height: 100vh;
            padding: 24px;
        }
    </style>
</head>

<body>
    <div class="register-wrapper">
        @yield('content')
    </div>
</body>

</html>
