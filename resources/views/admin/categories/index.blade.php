@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Categories</h1>

        <!-- Add New Category Button -->
        <div class="text-start mb-4">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary -pill px-4 py-2">Add New Category</a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($categories->isNotEmpty())
            <div class="card shadow border-0 -3">
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        @foreach ($categories as $category)
                            <li class="list-group-item border-0 py-3 bg-light  mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 fw-bold">{{ $category->name }}</h5>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning  me-2 px-3">Edit</a>
                                        <a href="{{ route('admin.subcategories.create', ['category' => $category->id]) }}" class="btn btn-sm btn-primary px-3">Add Subcategory</a>
                                    </div>
                                </div>


                                <!-- Display Subcategories -->
                                @if ($category->subcategories->isNotEmpty())
                                    <ul class="list-group mt-3 ms-4">
                                        @foreach ($category->subcategories as $subcategory)
                                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 bg-white shadow-sm  py-2 mb-2">
                                                <span class="fw-normal">{{ $subcategory->name }}</span>
                                                <a href="{{ route('admin.subcategories.edit', ['category' => $category->id, 'subcategory' => $subcategory->id]) }}" class="btn btn-sm btn-warning -pill px-3">Edit</a>
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
