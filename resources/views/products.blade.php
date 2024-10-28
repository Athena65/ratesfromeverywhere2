<div class="container my-5">
    <h2 class="text-center mb-4">Ürünlerimiz</h2>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Resim yok">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>

                        <!-- RFE Rating Display (Single Star) and Your Rating in the Same Row -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <small><strong>RFE Rating</strong></small>&nbsp;
                                <i class="fas fa-star rating-icon"></i>
                                <span class="fw-bold ms-1">{{ $product->site_rating }}</span><span class="text-muted">/5</span>
                            </div>
                            <div class="d-flex flex-column align-items-center" onclick="rateProduct({{ $product->id }})">
                                <small><strong>Your Rating</strong></small>
                                <div class="user-rating px-2 py-1 d-flex align-items-center" onclick="openRatingModal('{{ $product->name }}')">
                                    <i class="far fa-star me-1"></i> Rate
                                </div>
                            </div>
                        </div>
                        <!-- Include the modal -->
                        @include('rate_modal')

                        <!-- Global Rating Display (5 Stars) -->
                        <small><strong>Global Rating</strong></small><br>
                        <div class="d-flex align-items-center mb-2">
                            <div class="stars-outer me-2">
                                <div class="stars-inner" style="width: {{ ($product->global_rating / 5) * 100 }}%;"></div>
                            </div>
                            <span class="fw-bold">{{ $product->global_rating }}</span><span class="text-muted"></span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Henüz ürün yok. Yakında burada ürünlerimizi görebileceksiniz!</p>
        @endforelse
    </div>
</div>
