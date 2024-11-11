<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RFE - Yönetim Paneli')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Yıldızlar için ve diğer özel stiller -->
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<!-- Header -->
<header class="d-flex justify-content-between align-items-center p-3 bg-info text-white">
    <div class="logo">
        <a href="/" title="Ana Sayfa">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQhePsRBxByObW3FWQ5qDsxuflLEoRwjDooEA&s"
                 alt="Logo" style="height: 50px;">
        </a>
    </div>

    <div class="auth-button">
        @if(Route::is('admin.products.index'))
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary me-3">Yeni Kategori Ekle</a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-warning me-3">Yeni Ürün Ekle</a>
        @else
            <a href="{{ route('admin.products.index') }}" class="btn btn-light me-3">Ürün Listesine Dön</a>
        @endif
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Çıkış Yap</button>
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
    document.addEventListener('DOMContentLoaded', function() {
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