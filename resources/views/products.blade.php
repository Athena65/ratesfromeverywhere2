<div class="container my-5">
    <h2 class="text-center mb-4">Ürünlerimiz</h2>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">

                <div class="card h-100">
                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                             alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Resim yok">
                    @endif
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <!-- Product ratings -->
                        @include('product_rating', ['product' => $product])
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
