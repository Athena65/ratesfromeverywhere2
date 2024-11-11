@extends('layouts.admin')

@section('title', 'RFE - Ürünü Düzenle')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Ürünü Düzenle</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="form-label fw-bold">Ürün Adı</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label fw-bold">Açıklama</label>
                <textarea class="form-control" id="description" name="description" rows="3"
                          required>{{ $product->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="global_rating" class="form-label fw-bold">Genel Değerlendirme</label>
                <input type="number" class="form-control" id="global_rating" name="global_rating"
                       value="{{ $product->global_rating }}" step="0.1" min="0" max="5">
            </div>

            <div class="mb-4">
                <label for="image" class="form-label fw-bold">Ürün Resmi</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                @if($product->image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Mevcut Resim" class="img-thumbnail"
                             style="width: 150px;">
                    </div>
                @endif
            </div>
            <!-- Category Selection -->
            @include('admin.categories.select-one')

            <button type="submit" class="btn btn-primary w-100 py-2">Güncelle</button>
        </form>
    </div>
    <!-- to list subcategories of categories -->
    @vite('resources/js/admin-category-subcategory.js')
@endsection
