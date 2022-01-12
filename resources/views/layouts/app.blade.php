<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{-- csrf token --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'LaraBBS')</title>

  {{-- styles --}}
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
  <div class="{{ route_class() }}-page" id="app">
    @include('layouts._header')
    <div class="container">
      @include('shared._messages')
      @yield('content')
    </div>
    @include('layouts._footer')
  </div>

  {{-- scripts --}}
  <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
