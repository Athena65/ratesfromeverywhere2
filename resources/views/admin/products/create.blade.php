@extends('layouts.admin')

@section('title', 'Yeni Ürün Ekle')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Yeni Ürün Ekle</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="form-label fw-bold">Ürün Adı</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label fw-bold">Açıklama</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>

            <div class="mb-4">
                <label for="global_rating" class="form-label fw-bold">Genel Değerlendirme</label>
                <input type="number" class="form-control" id="global_rating" name="global_rating" step="0.1" min="0" max="5">
            </div>

            <div class="mb-4">
                <label for="image" class="form-label fw-bold">Ürün Resmi</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <!-- Category Selection -->
            <div class="mb-4">
                <label class="form-label fw-bold">Kategoriler</label>
                <div class="p-3 border rounded bg-light">
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-md-6 col-lg-4 mb-2">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="categories[]"
                                        value="{{ $category->id }}"
                                        id="category{{ $category->id }}">
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Oluştur</button>
        </form>
    </div>
@endsection
