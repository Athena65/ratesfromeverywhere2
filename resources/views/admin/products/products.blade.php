<div class="container my-5">
    <h2 class="text-center mb-4">Ürünlerimiz</h2>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                             alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Resim yok">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>

                        <!-- RFE Rating Display (Single Star) and Your Rating in the Same Row -->
                        <small><strong>RFE Rating</strong></small><br>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center mb-2">
                                <div class="stars-outer me-2">
                                    <div class="stars-inner"
                                         style="width: {{ ($product->site_rating / 5) * 100 }}%;"></div>
                                </div>
                                <span class="fw-bold">{{ $product->site_rating }}</span><span class="text-muted"></span>
                            </div>
                        </div>
                        <!-- Global Rating Display (5 Stars) -->
                        <small><strong>Global Rating</strong></small><br>
                        <div class="d-flex align-items-center mb-2">
                            <div class="stars-outer me-2">
                                <div class="stars-inner"
                                     style="width: {{ ($product->global_rating / 5) * 100 }}%;"></div>
                            </div>
                            <span class="fw-bold">{{ $product->global_rating }}</span><span class="text-muted"></span>
                        </div>
                    </div>
                        <!-- delete update -->
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Düzenle</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                              onsubmit="return confirm('Bu ürünü silmek istediğinizden emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Sil</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Henüz ürün yok. Yakında burada ürünlerimizi görebileceksiniz!</p>
        @endforelse
    </div>
</div>
