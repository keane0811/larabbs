<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">
    {{-- branding image --}}
    <a href="{{ url('/') }}" class="navbar-brand">LaraBBS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      {{-- left side of navbar --}}
      <ul class="navbar-nav me-auto"></ul>

      {{-- right side of navbar --}}
      <ul class="navbar-nav">
        {{-- authentication links --}}
        <li class="nav-item"><a href="#" class="nav-link">登录</a></li>
        <li class="nav-item"><a href="#" class="nav-link">注册</a></li>
      </ul>
    </div>
  </div>
</nav>
