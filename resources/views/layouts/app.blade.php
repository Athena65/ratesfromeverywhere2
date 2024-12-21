<!DOCTYPE html>
<!-- main html-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rates From Everywhere')</title>
    <!-- ajax csrf korumasi -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- yildizlar icin -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('storage/constantimages/RFE--Logo.png') }}">
    <!-- Bootstrap and Font Awesome Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</head>
<body>
<!-- Header -->
<header class="d-flex justify-content-between align-items-center p-3 text-white" style="background-color:#00509E;">
    <!-- Logo ve Dil Ayarla -->
    <div class="logo d-flex align-items-center">
        <a href="/" title="Home">
            <img src="{{ asset('storage/constantimages/RFE--Logo.png') }}" alt="Logo" style="height: 75px;">
        </a>
        <h1 class="ms-3 mb-0" style="font-size: 1.5rem; color: #333;">RFE</h1>

        <!-- Dil Ayarla Dropdown -->
        <div class="dropdown ms-3">
            <button class="btn btn-outline-light dropdown-toggle" type="button" id="languageDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                {{ __('messages.configurelang') }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                <li><a class="dropdown-item" href="{{ route('change.language', 'tr') }}">Türkçe</a></li>
                <li><a class="dropdown-item" href="{{ route('change.language', 'en') }}">English</a></li>
            </ul>
        </div>
    </div>

    <!-- Auth Button -->
    <div class="auth-button">
        @auth
            <span class="me-3">{{__('messages.welcome')}}, {{ Auth::user()->name }}</span>
            <!-- Admin kullanıcıları için Admin Panel butonu -->
            @if(Auth::user()->is_admin == 1)
                <a href="{{ route('admin.products.index') }}" class="btn btn-warning me-3 admin-button"
                   style="max-width: 250px;">
                    <span>{{ __('messages.adminpanel') }}</span>
                </a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">{{ __('messages.logout') }}</button>
            </form>
        @else
            <!-- Route kontrolü -->
            @if(request()->is('login'))
                <a href="{{ route('register') }}" class="btn btn-secondary">{{ __('messages.register') }}</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary">{{ __('messages.login') }}</a>
            @endif
        @endauth
    </div>
</header>


<!-- Başarı Mesajı -->
@if(session('success'))
    <div id="successMessage" class="alert alert-success text-center mt-3">
        {{ session('success') }}
    </div>
@endif

<!-- Ana İçerik -->
<main class="container my-5">
    @yield('content')
</main>

<script>
    // Başarı mesajını 3 saniye sonra gizle
    document.addEventListener('DOMContentLoaded', function () {
        var successMessage = document.getElementById('successMessage');
        if (successMessage) {
            setTimeout(function () {
                successMessage.style.display = 'none';
            }, 3000); // 3000 ms = 3 saniye
        }
    });
</script>

</body>
</html>
