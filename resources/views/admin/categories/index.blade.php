@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Categories</h1>

        <div class="text-start mb-4">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add New Category</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($categories->isNotEmpty())
            <div class="card shadow-sm">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($categories as $category)
                            <li class="list-group-item py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ $category->name }}</h5>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                        <a href="{{ route('admin.subcategories.create', ['category' => $category->id]) }}" class="btn btn-sm btn-primary">Add Subcategory</a>
                                    </div>
                                </div>

                                <!-- Display Subcategories -->
                                @if ($category->subcategories->isNotEmpty())
                                    <ul class="list-group mt-3 ms-4">
                                        @foreach ($category->subcategories as $subcategory)
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                <span>{{ $subcategory->name }}</span>
                                                <a href="{{ route('admin.subcategories.edit', ['category' => $category->id, 'subcategory' => $subcategory->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="alert alert-light mt-3 ms-4 mb-0">No subcategories available.</div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center mt-4">No categories available.</div>
        @endif
    </div>
@endsection
