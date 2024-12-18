@extends('layouts.app')

@section('title', __('messages.similar_products'))

@section('content')
    <div class="container my-5">
        <h1 class="mb-4 text-center fw-bold">{{ __('messages.similar_products') }}</h1>
        <div class="row g-4">
            @forelse($similarProducts as $product)
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm rounded">
                        <!-- Ürün Resmi -->
                        <a href="{{ route('products.show', $product->id) }}">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="card-img-top rounded-top"
                                     alt="{{ $product->name }}"
                                     style="height: 100%; max-height: 500px; object-fit: contain;">
                            </div>
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate fw-semibold mb-2">{{ $product->name }}</h5>
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($product->description, 100, '...') }}
                            </p>
                            <!-- Ürün Değerlendirme Yıldızları -->
                            <div class="mb-3">
                                @include('product/product_rating_readonly', ['product' => $product])
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        {{ __('messages.no_similar_products') }}
                    </div>
                    <!-- Yeni Sayfaya Yönlendirme -->
                    <div class="text-center mt-3">
                        <a href="{{ route('product.requestForm') }}" class="btn btn-primary">
                            {{ __('messages.request_add_product') }}
                        </a>
                    </div>
                </div>
            @endforelse



        </div>
    </div>
@endsection
