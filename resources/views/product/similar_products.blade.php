@extends('layouts.app')

@section('title', __('messages.similar_products'))

@section('content')
    <div class="container my-5">
        <h1 class="mb-4 text-center">{{ __('messages.similar_products') }}</h1>
        <div class="row">
            @forelse($similarProducts as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <!-- Ürün Resmi -->
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 class="card-img-top img-fluid"
                                 alt="{{ $product->name }}"
                                 style="max-height: 200px; object-fit: cover;">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>
                            <a href="{{ route('products.show', $product->id) }}"
                               class="btn btn-primary mt-auto">
                                {{ __('messages.view_product') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">{{ __('messages.no_similar_products') }}</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
