<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Yeni Ürün Ekle</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Ürün Adı</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Açıklama</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Ürün Resmi</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="site_rating" class="form-label">Site İçi Değerlendirme</label>
            <input type="number" class="form-control" id="site_rating" name="site_rating" step="0.1" min="0" max="5">
        </div>

        <div class="mb-3">
            <label for="global_rating" class="form-label">Genel Değerlendirme</label>
            <input type="number" class="form-control" id="global_rating" name="global_rating" step="0.1" min="0"
                   max="5">
        </div>

        <button type="submit" class="btn btn-primary">Ürün Ekle</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
