<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RFE - Yönetim Paneli')</title>
    <!-- Yıldızlar için ve diğer özel stiller -->
    @vite('resources/css/app.css')
</head>
<body>
<!-- Header -->
<header class="d-flex justify-content-between align-items-center p-3 bg-info text-white">
    <div class="d-flex align-items-center">
        <div class="logo me-3">
            <a href="/" title="Ana Sayfa">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQhePsRBxByObW3FWQ5qDsxuflLEoRwjDooEA&s"
                     alt="Logo" style="height: 50px;">
            </a>
        </div>

        <!-- Dil Ayarla Dropdown -->
        <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                {{__('messages.configurelang')}}
            </button>
            <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                <li><a class="dropdown-item" href="{{ route('change.language', 'tr') }}">Türkçe</a></li>
                <li><a class="dropdown-item" href="{{ route('change.language', 'en') }}">English</a></li>
            </ul>
        </div>
    </div>

    <div class="auth-button">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
