<!-- Rating Modal -->
<div class="modal fade rating-modal" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <!-- Icon with Question Mark -->
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 id="modalProductName" class="mb-1">Product Name</h6> <!-- Placeholder for dynamic product name -->
                <div class="rating-stars d-flex justify-content-center my-3">
                    <!-- 5-star rating system with hover effect -->
                    <i class="far fa-star" data-rating="1"></i>
                    <i class="far fa-star" data-rating="2"></i>
                    <i class="far fa-star" data-rating="3"></i>
                    <i class="far fa-star" data-rating="4"></i>
                    <i class="far fa-star" data-rating="5"></i>
                </div>
                <button class="btn-rate" onclick="submitRating()">Rate</button>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap and Font Awesome Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<!-- Include rate_modal.js using Vite -->
@vite('resources/js/rate_modal.js')


