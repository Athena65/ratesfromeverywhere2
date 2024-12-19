@extends('layouts.app')

@section('title', __('messages.request_add_product'))

@section('content')
    <div class="container my-5">
        <h1 class="text-center">{{ __('messages.request_add_product') }}</h1>
        <!-- Hata ve Başarı Mesajları -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('product.storeRequest') }}" id="productRequestForm" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Ürün Adı -->
            <div class="mb-3">
                <label for="product_name" class="form-label">{{ __('messages.product_name') }}</label>
                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="{{ __('messages.enter_product_name') }}" required>
            </div>
            <!-- Resim Yükleme veya URL -->
            @if(session('uploaded_image_url'))
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.image_url') }}</label>
                    <input type="url" class="form-control" name="image_url" value="{{ session('uploaded_image_url') }}" readonly>
                </div>
            @elseif(session('uploaded_image_path'))
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.uploaded_image') }}</label>
                    <img src="{{ asset('storage/' . session('uploaded_image_path')) }}" class="img-fluid rounded mb-3" style="max-height: 150px;" alt="Uploaded Image">
                    <input type="hidden" name="uploaded_image_path" value="{{ session('uploaded_image_path') }}">
                </div>
            @else
                <div class="mb-3">
                    <label for="image" class="form-label">{{ __('messages.upload_image') }}</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
            @endif


            <!-- Açıklama -->
            <div class="mb-3">
                <label for="description" class="form-label">{{ __('messages.description') }}</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="{{ __('messages.enter_description') }}"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('messages.submit_request') }}</button>
        </form>
    </div>
@endsection
<script>
    window.isAuthenticated = @json(auth()->check()); // Kullanıcı giriş durumunu JavaScript'e aktarır
    window.loginUrl = "{{ route('login') }}"; // Laravel'in login URL'sini aktarır
</script>
@vite('resources/js/redirect_to_login.js')
