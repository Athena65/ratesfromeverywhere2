<div class="container my-5">
    <h2 class="text-center mb-4">Ürünlerimiz</h2>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                             alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Resim yok"
                             style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $product->name }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>

                        <!-- Category and Subcategory Display -->
                        @include('partials.categories.display')


                        <!-- RFE Rating Display -->
                        <div class="mb-2">
                            <small><strong>RFE Rating:</strong></small>
                            <div class="d-flex align-items-center">
                                <div class="stars-outer me-2">
                                    <div class="stars-inner"
                                         style="width: {{ ($product->site_rating / 5) * 100 }}%;"></div>
                                </div>
                                <span class="fw-bold">{{ $product->site_rating }}</span>
                            </div>
                        </div>

                        <!-- Global Rating Display -->
                        <div class="mb-2">
                            <small><strong>Global Rating:</strong></small>
                            <div class="d-flex align-items-center">
                                <div class="stars-outer me-2">
                                    <div class="stars-inner"
                                         style="width: {{ ($product->global_rating / 5) * 100 }}%;"></div>
                                </div>
                                <span class="fw-bold">{{ $product->global_rating }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer with Edit and Delete -->
                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">Düzenle</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                              onsubmit="return confirm('Bu ürünü silmek istediğinizden emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Henüz ürün yok. Yakında burada ürünlerimizi görebileceksiniz!</p>
        @endforelse
    </div>
</div>
