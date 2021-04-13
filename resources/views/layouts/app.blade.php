<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  {{-- CSRF token --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'LaraBBS')</title>
  <meta name="description" content="@yield('description', 'LaraBBS')">

  {{-- Styles --}}
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  @yield('styles')
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

  @if (app()->isLocal())
    @include('sudosu::user-selector')
  @endif

  {{-- Scripts --}}
  <script src="{{ mix('js/app.js') }}"></script>
  @yield('scripts')
</body>

</html>
