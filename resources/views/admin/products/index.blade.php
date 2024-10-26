<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ürün Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQhePsRBxByObW3FWQ5qDsxuflLEoRwjDooEA&s"
                 alt="Logo" style="height: 50px;">
        </a>
    </div>

    <div class="auth-button">
        <a href="{{ route('admin.products.create') }}" class="btn btn-warning me-3">Yeni Ürün Ekle</a>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Çıkış Yap</button>
        </form>
    </div>
</header>

<!-- Ana İçerik -->
<main class="container my-5">
    <!-- Başarı Mesajı -->
    @if(session('success'))
        <div class="alert alert-success text-center mt-3">
            {{ session('success') }}
        </div>
    @endif
    <h2 class="text-center mb-4">Ürün Yönetimi</h2>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                             alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Resim yok">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p><strong>Site İçi Değerlendirme:</strong> {{ $product->site_rating }} / 5</p>
                        <p><strong>Genel Değerlendirme:</strong> {{ $product->global_rating }} / 5</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Düzenle</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                              onsubmit="return confirm('Bu ürünü silmek istediğinizden emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Sil</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Henüz ürün yok. Ürün eklemek için "Yeni Ürün Ekle" butonunu kullanabilirsiniz.</p>
        @endforelse
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
