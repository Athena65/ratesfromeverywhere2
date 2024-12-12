@extends('layouts.app')

@section('title', __('messages.upload_image'))

@section('content')
    <div class="container my-5">
        <h2 class="text-center mb-4">{{ __('messages.upload_or_enter_url') }}</h2>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('product.findSimilarByUpload') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Kullanıcıya Seçim Sor -->
            <div class="mb-4">
                <label for="uploadMethod" class="form-label fw-bold">{{ __('messages.choose_upload_method') }}</label>
                <select class="form-select" id="uploadMethod" onchange="toggleUploadMethod()" required>
                    <option value="">{{ __('messages.select_option') }}</option>
                    <option value="image">{{ __('messages.upload_image') }}</option>
                    <option value="url">{{ __('messages.enter_image_url') }}</option>
                </select>
            </div>

            <!-- Resim Yükleme Alanı -->
            <div class="mb-4 d-none" id="imageUploadDiv">
                <label for="image" class="form-label fw-bold">{{ __('messages.upload_image') }}</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <!-- URL Girme Alanı -->
            <div class="mb-4 d-none" id="urlInputDiv">
                <label for="url" class="form-label fw-bold">{{ __('messages.or_enter_image_url') }}</label>
                <input type="url" class="form-control" id="url" name="url" placeholder="https://example.com/image.jpg">
            </div>

            <button type="submit" class="btn btn-primary w-100">{{ __('messages.find_similar') }}</button>
        </form>
    </div>

    <script>
        function toggleUploadMethod() {
            const selectedMethod = document.getElementById('uploadMethod').value;
            const imageUploadDiv = document.getElementById('imageUploadDiv');
            const urlInputDiv = document.getElementById('urlInputDiv');

            // Seçime göre alanları göster veya gizle
            if (selectedMethod === 'image') {
                imageUploadDiv.classList.remove('d-none');
                urlInputDiv.classList.add('d-none');
            } else if (selectedMethod === 'url') {
                urlInputDiv.classList.remove('d-none');
                imageUploadDiv.classList.add('d-none');
            } else {
                imageUploadDiv.classList.add('d-none');
                urlInputDiv.classList.add('d-none');
            }
        }
    </script>
@endsection
