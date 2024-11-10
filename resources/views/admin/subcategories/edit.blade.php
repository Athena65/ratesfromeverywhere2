@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Edit Subcategory for {{ $category->name }}</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Subcategory Update Form -->
                <form action="{{ route('admin.subcategories.update', [$category, $subcategory]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Subcategory Name</label>
                        <input type="text" name="name" class="form-control" id="name"
                               value="{{ old('name', $subcategory->name) }}" required>
                        @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Button Group for Update, Delete, and Cancel -->
                    <div class="d-flex justify-content-start mt-4">
                        <button type="submit" class="btn btn-success me-2">Update</button>

                        <!-- Delete Form -->
                        <form
                            action="{{ route('admin.subcategories.destroy', ['category' => $category->id, 'subcategory' => $subcategory->id]) }}"
                            method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger me-2"
                                    onclick="return confirm('Are you sure you want to delete this subcategory?')">Delete
                            </button>
                        </form>

                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
