<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-center mb-0">{{ __('messages.ourproducts') }}</h2>
        <a href="{{ route('product.uploadForm') }}" class="btn btn-primary">{{ __('messages.find_similar') }}</a>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100  ">
                    <div class="d-flex">
                        <!-- Resim Alanı -->
                        <div style="width: 40%;">
                            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                         alt="{{ $product->name }}" style="height: 100%; object-fit: contain;">
                                @else
                                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Resim yok"
                                         style="height: 100%; object-fit: contain;">
                                @endif
                            </a>
                        </div>

                        <!-- Ürün Detayları Alanı -->
                        <div class="card-body" style="width: 60%;">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>

                            <!-- Kategori ve Alt Kategori Görüntüleme -->
                            @include('partials.categories.display')

                            <!-- Ürün Puanlama -->
                            @include('product_rating', ['product' => $product])
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Henüz ürün yok. Yakında burada ürünlerimizi görebileceksiniz!</p>
        @endforelse
    </div>
</div>

<!-- rate modal css -->
@vite('resources/css/rate_modal.css')
<!-- rate_modal -->
@include('rate_modal')
