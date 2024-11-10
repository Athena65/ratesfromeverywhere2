@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Add New Subcategory for {{ $category->name }}</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.subcategories.store', $category) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Subcategory Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter subcategory name" required>
                        @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-start mt-4">
                        <button type="submit" class="btn btn-success me-2">Create</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
