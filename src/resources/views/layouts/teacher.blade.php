<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <title>@yield('title')</title>
        @livewireStyles
        @vite('resources/css/style-teacher.css')
        @vite('resources/css/globals.css')
    </head>
    <body>
        @yield('content')
        @livewireScripts
    </body>
</html>
