<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <title>@yield('title')</title>
</head>
<body>
    <div class="max-h-screen bg-[#eeeeee] overflow-hidden">
        @yield('content')
    </div>
</body>
</html>
