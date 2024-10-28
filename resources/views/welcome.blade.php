<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rates From Everywhere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- yildizlar icin -->
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* urun resmi duzeltmesi */
        .card-img-top {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>
<body>
<!-- Header -->
<header class="d-flex justify-content-between align-items-center p-3 bg-primary text-white">
    <div class="logo">
        <a href="/" title="Ana Sayfa">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQhePsRBxByObW3FWQ5qDsxuflLEoRwjDooEA&s" alt="Logo" style="height: 50px;">
        </a>
    </div>

    <div class="auth-button">
        @auth
            <span class="me-3">Hoşgeldin, {{ Auth::user()->name }}</span>
            <!-- Admin kullanıcıları için Admin Panel butonu -->
            @if(Auth::user()->is_admin == 1)
                <a href="{{ route('admin.products.index') }}" class="btn btn-warning me-3">Admin Panel</a>
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
<!-- Ana İçerik: products.blade.php-->
<main class="container my-5">
    @include('products')
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
