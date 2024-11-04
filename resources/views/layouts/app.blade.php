<!DOCTYPE html>
<!-- main html-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rates From Everywhere')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- yildizlar icin -->
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- ajax csrf korumasi -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<!-- Header -->
<header class="d-flex justify-content-between align-items-center p-3 bg-primary text-white">
    <div class="logo d-flex align-items-center">
        <a href="/" title="Home">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQhePsRBxByObW3FWQ5qDsxuflLEoRwjDooEA&s" alt="Logo" style="height: 50px;">
        </a>
        <h1 class="ms-3 mb-0" style="font-size: 1.5rem; color: #333;">Rates From Everywhere</h1>
    </div>

    <div class="auth-button">
        @auth
            <span class="me-3">Hoşgeldin, {{ Auth::user()->name }}</span>
            <!-- Admin kullanıcıları için Admin Panel butonu -->
            @if(Auth::user()->is_admin == 1)
                <a href="{{ route('admin.products.index') }}" class="btn btn-warning me-3 admin-button" style="max-width: 250px;">
                    <span>Admin Panel</span>
                </a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Çıkış Yap</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-success">Giriş Yap</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Başarı mesajını 3 saniye sonra gizle
    document.addEventListener('DOMContentLoaded', function() {
        var successMessage = document.getElementById('successMessage');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 3000); // 3000 ms = 3 saniye
        }
    });
</script>

</body>
</html>
