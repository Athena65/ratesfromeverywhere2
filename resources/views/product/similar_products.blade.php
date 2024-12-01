@extends('layouts.app')

@section('title', __('messages.similar_products'))

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">{{ __('messages.similar_products') }}</h1>
        <div class="row">
            @forelse($similarProducts as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">{{ __('messages.view_product') }}</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>{{ __('messages.no_similar_products') }}</p>
            @endforelse
        </div>
    </div>
@endsection
