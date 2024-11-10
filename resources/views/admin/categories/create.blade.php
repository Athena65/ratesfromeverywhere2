@extends('layouts.admin')

@section('title', 'Yeni Kategori Ekle')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Yeni Kategori Ekle</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Kategori Adı:</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Kategori Adını Girin" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary w-50 me-2">Save</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary w-50">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
