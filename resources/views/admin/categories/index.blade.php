@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Categories</h1>

        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Add New Category</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($categories->isNotEmpty())
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($categories as $category)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $category->name }}</span>
                                <div>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="alert alert-info">No categories available.</div>
        @endif
    </div>
@endsection
