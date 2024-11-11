@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h4 class="mb-4">Edit Subcategory for {{ $category->name }}</h4>

        <div class="card">
            <div class="card-body">
                <!-- Subcategory Update Form -->
                <form action="{{ route('admin.subcategories.update', [$category, $subcategory]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Subcategory Name:</label>
                        <input type="text" name="name" class="form-control" id="name"
                               value="{{ old('name', $subcategory->name) }}" required>
                        @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Update Button -->
                    <button type="submit" class="btn btn-success">Update</button>
                </form>

                <!-- Delete Form -->
                <form action="{{ route('admin.subcategories.destroy', ['category' => $category->id, 'subcategory' => $subcategory->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this subcategory?')">Delete</button>
                </form>

                <!-- Cancel Button -->
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
@endsection
