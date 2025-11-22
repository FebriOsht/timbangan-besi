<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ config('app.name','WebBesi') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
  @include('layouts.navigation') <!-- breeze menyediakan -->
  <main>
    @yield('content')
  </main>
</body>
</html>
