<div class="d-flex flex-wrap">
    <!-- Kategoriler -->
    @if($product->categories)
        @foreach($product->categories as $category)
            <span class="badge bg-info text-dark me-1 mb-1 px-2 py-1">{{ $category->name }}</span>
        @endforeach
    @endif

    <!-- Alt Kategoriler -->
    @if($product->subcategories)
        @foreach($product->subcategories as $subcategory)
            <span class="badge bg-secondary text-light me-1 mb-1 px-2 py-1">{{ $subcategory->name }}</span>
        @endforeach
    @endif
</div>
