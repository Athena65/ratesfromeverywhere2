@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container my-5">
        <div class="row">
            <!-- Ürün Resmi -->
            <div class="col-md-6 text-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-4" alt="{{ $product->name }}" style="max-height: 550px">
                @else
                    <img src="https://via.placeholder.com/300" class="img-fluid mb-4" alt="Resim yok">
                @endif
            </div>

            <!-- Ürün Bilgileri -->
            <div class="col-md-6 d-flex flex-column justify-content-between">
                <div>
                    <h1 class="mb-3">{{ $product->name }}</h1>
                    <p class="text-muted mb-4">{{ $product->description }}</p>
                    <!-- Kategori ve Alt Kategori Görüntüleme -->
                    @include('partials.categories.display')
                    <!-- Ürün Oylama Bölümü -->
                    <div class="mb-3">
                        @include('product_rating', ['product' => $product])
                    </div>
                </div>

                <div class="card mt-3 p-3 text-center">
                    <form action="{{ route('products.findSimilar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-primary w-100">{{ __('messages.find_similar') }}</button>
                    </form>
                </div>


            </div>
        </div>
    </div>

    <!-- rate modal css -->
    @vite('resources/css/rate_modal.css')
    <!-- rate_modal -->
    @include('rate_modal')
@endsection
