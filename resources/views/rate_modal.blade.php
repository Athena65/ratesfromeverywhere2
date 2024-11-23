<!-- Rating Modal -->
<div class="modal fade rating-modal" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        onclick="closeModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display selected rating -->
                <div id="selectedRatingDisplay" class="mb-2"></div>

                <!-- Product name -->
                <h6 id="modalProductName" class="mb-1">Product Name</h6> <!-- Placeholder for dynamic product name -->

                <!-- 5-star rating system with hover effect -->
                <div class="rating-stars d-flex justify-content-center my-3">
                    <i class="far fa-star" data-rating="1"></i>
                    <i class="far fa-star" data-rating="2"></i>
                    <i class="far fa-star" data-rating="3"></i>
                    <i class="far fa-star" data-rating="4"></i>
                    <i class="far fa-star" data-rating="5"></i>
                </div>

                <!-- Rate button -->
                <button class="btn-rate" onclick="submitRating()">{{__('messages.rate')}}</button>

                <!-- Remove rating button -->
                <div style="text-align: center;">
                    <button class="btn-remove-rating mt-2" onclick="removeRating()"
                            style="color: blue; background: none; border: none;">{{__('messages.removerating')}}
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Bootstrap and Font Awesome Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<!-- Rate URL'leri tanımlayın -->
<script>
    window.rateProductUrl = @json(route('rate.product'));
    window.removeRatingUrl = @json(route('remove.rating'));
    // Kullanıcının giriş yapıp yapmadığını kontrol eden değişken
    let isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
    let loginUrl = "{{ route('login') }}"; // Giriş sayfasının URL'sini alın
</script>
<!-- rate_modal.js dosyasını yükleyin -->
@vite('resources/js/rate_modal.js')


