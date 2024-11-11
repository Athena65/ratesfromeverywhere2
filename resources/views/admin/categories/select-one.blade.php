<div class="mb-4">
    <label class="form-label fw-bold">Kategoriler</label>
    <div class="p-3 border rounded bg-light">
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-6 col-lg-4 mb-2">
                    <div class="form-check">
                        <input
                            class="form-check-input category-checkbox"
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            id="category{{ $category->id }}"
                            {{ $product->categories->contains($category->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="mb-4">
    <label class="form-label fw-bold">Alt Kategoriler</label>
    <div class="p-3 border rounded bg-light" id="subcategoryContainer">
        <!-- Alt kategoriler dinamik olarak eklenecek -->
        @foreach ($product->subcategories as $subcategory)
            <div class="col-md-6 col-lg-4 mb-2">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="subcategories[]"
                        value="{{ $subcategory->id }}"
                        id="subcategory{{ $subcategory->id }}"
                        checked>
                    <label class="form-check-label" for="subcategory{{ $subcategory->id }}">
                        {{ $subcategory->name }}
                    </label>
                </div>
            </div>

        @endforeach
    </div>
</div>

<!-- JavaScript'te kullanmak üzere productId'yi tanımlayın -->

<script>
    const productId = @json($product->id);
</script>
