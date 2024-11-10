@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Category</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name:</label>
                        <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                </form>

                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn  btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>

                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
