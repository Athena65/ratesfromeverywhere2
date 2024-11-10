<div class="mb-4">
    <label class="form-label fw-bold">Kategoriler</label>
    <div class="p-3 border rounded bg-light">
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-6 col-lg-4 mb-2">
                    <div class="form-check">
                        <input
                            class="form-check-input"
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
