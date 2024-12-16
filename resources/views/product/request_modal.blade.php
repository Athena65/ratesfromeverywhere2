<!-- Modal -->
<div class="modal fade" id="productRequestModal" tabindex="-1" aria-labelledby="productRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productRequestModalLabel">{{ __('messages.request_add_product') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="productRequestForm" action="{{ route('product.storeRequest') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Ürün Adı -->
                    <div class="mb-3">
                        <label for="product_name" class="form-label">{{ __('messages.product_name') }}</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="{{ __('messages.enter_product_name') }}" required>
                    </div>
                    <!-- Resim URL veya Yükleme Kontrolü -->
                    @if(isset($uploaded_image_path))
                        <!-- Yüklenmiş Resim Görüntüleme -->
                        <div class="mb-3">
                            <label for="uploaded_image" class="form-label">{{ __('messages.uploaded_image') }}</label>
                            <img src="{{ $uploaded_image_path }}" alt="Uploaded Image" class="img-fluid rounded mb-2" style="max-height: 150px;">
                            <input type="hidden" name="image" value="{{ $uploaded_image_path }}">
                        </div>
                    @elseif(isset($uploaded_image_url))
                        <!-- URL Girilmişse Görüntüleme -->
                        <div class="mb-3">
                            <label for="image_url" class="form-label">{{ __('messages.image_url') }}</label>
                            <input type="url" class="form-control" id="image_url" name="image_url"
                                   value="{{ $uploaded_image_url }}" readonly>
                        </div>
                    @else
                        <!-- Resim Yükleme Alanı -->
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('messages.submit_request') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const isAuthenticated = @json(auth()->check()); // Kullanıcı giriş yapmışsa true, değilse false
    const loginUrl = "{{ route('login') }}"; // Laravel'deki login route'u
</script>
@vite('resources/js/redirect_to_login.js')
