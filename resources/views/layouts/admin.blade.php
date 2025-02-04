<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RFE - Yönetim Paneli')</title>
    <!-- Yıldızlar için ve diğer özel stiller -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('storage/constantimages/RFE--Logo.png') }}">

    <!-- Bootstrap and Font Awesome Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</head>
<body>
<!-- Header -->
<header class="d-flex justify-content-between align-items-center p-3 text-white" style="background-color:#00509E;">
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

    <div class="auth-button">
        <!-- Message Icon -->
        <a href="{{ route('admin.requests.index') }}" class="btn btn-light me-3 position-relative">
            <i class="fas fa-envelope"></i>
            @if(isset($unreadRequests) && $unreadRequests > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $unreadRequests }}
        </span>
            @endif
        </a>
        @if(Route::is('admin.products.index'))
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary me-3">{{__('messages.addnewcategory')}}</a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-warning me-3">{{__('messages.addnewproduct')}}</a>
        @else
            <a href="{{ route('admin.products.index') }}" class="btn btn-light me-3">{{__('messages.backtoproductlist')}}</a>
        @endif
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">{{ __('messages.logout') }}</button>
        </form>
    </div>
</header>

<!-- Ana İçerik -->
<main class="container my-5">
    @yield('content')
</main>

<script>
    //disappearing alerts
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            // Skip alert elements with the 'alert-info' class
            if (!alert.classList.contains('alert-info')) {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500); // Remove from DOM after fade out
                }, 2000);
            }
        });
    });
</script>
</body>
</html>
