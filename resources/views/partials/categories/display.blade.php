<div class="mb-3">
    @if($product->categories->isNotEmpty())
        <div class="d-flex flex-wrap mt-1">
            @foreach($product->categories as $category)
                <span class="badge bg-info text-dark me-1 mb-1">{{ $category->name }}</span>
            @endforeach
        </div>
    @else
        <span class="text-muted">Kategori yok</span>
    @endif
</div>
