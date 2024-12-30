<style>
    /* Global ratings */
    .global-rating-container {
        display: inline-block;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    .star-container {
        display: inline-block;
        font-size: 20px;
        color: #ffc107;
        position: relative;
        width: 24px;
        height: 24px;
    }

    .star-container .partial-star {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: white;
        z-index: 1;
    }

    /*global rating button*/
    .global-rating-container:hover [id^="update-rating"] {
        display: flex !important;
        opacity: 1; /* Smoothly fade in */
    }


    [id^="update-rating"] {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%; /* Match the container's width */
        height: 100%; /* Match the container's height */
        background-color: rgba(0, 0, 255, 0.5); /* More transparent blue */
        color: white;
        border: none;
        border-radius: 10px; /* Match the container's border radius */
        cursor: pointer;
        z-index: 10;
        font-size: 16px;
        opacity: 0;
        transition: opacity 1.0s ease-in-out, background-color 0.3s ease-in-out;
        justify-content: center;
        align-items: center;
    }

    [id^="update-rating"]:hover {
        background-color: rgba(0, 0, 200, 0.7); /* Slightly darker but still transparent */
    }

    /*loading animation*/
    .global-rating-container .loading-animation {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(255, 255, 255, 0.5); /* Hafif beyaz saydamlık */
        z-index: 5;
    }


</style>
<!-- Global Rating -->
<div class="d-flex justify-content-between align-items-center">
    <div class="global-rating-label">
        <h5 class="review-stat fw-medium mb-0">Global Rating:</h5>
    </div>
    <div class="global-rating-container position-relative text-end">
        <button id="update-rating-{{ $product->id }}"
                class="btn btn-primary position-absolute top-50 start-50 translate-middle d-none"
                data-product-name="{{ $product->name }}">
            Update Global Rating
        </button>

        <!-- Loading Animation -->
        <div id="loading-{{ $product->id }}" class="loading-animation d-none position-absolute top-50 start-50 translate-middle">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="rating-content d-inline-block">
            @php
                // Eğer tam sayı ise .00 göstermeden yaz, değilse uygun formatla
                $globalRating = (intval($product->global_rating) == $product->global_rating)
                    ? intval($product->global_rating) // Tam sayıysa
                    : (round($product->global_rating, 2) == round($product->global_rating, 1) ? round($product->global_rating, 1) : number_format($product->global_rating, 2)); // Değilse uygun yuvarlama
            @endphp
            <span id="global-rating-{{ $product->id }}" class="fw-bold me-2">
                {{ $globalRating }}
            </span>
            <div id="stars-{{ $product->id }}" class="d-inline-flex">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= floor($product->global_rating))
                        <div class="star-container position-relative">
                            <i class="fa fa-star full-star"></i>
                        </div>
                    @elseif ($i === ceil($product->global_rating) && $product->global_rating - floor($product->global_rating) > 0)
                        <div class="star-container position-relative">
                            <i class="fa fa-star full-star"></i>
                            <div class="partial-star" style="width: {{ ($product->global_rating - floor($product->global_rating)) * 100 }}%;"></div>
                        </div>
                    @else
                        <div class="star-container position-relative">
                            <i class="fa fa-star"></i>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.btn.btn-primary').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.id.split('-')[2]; // Extract the product ID from the button ID
            const productName = this.getAttribute('data-product-name'); // Get the product name from the data attribute
            const globalRatingElement = document.getElementById(`global-rating-${productId}`);
            const starsContainer = document.getElementById(`stars-${productId}`);

            // Show loading animation
            const loading = document.getElementById(`loading-${productId}`);
            loading.classList.remove('d-none');

            // Perform AJAX request
            fetch('/api/get-global-rating', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    product_name: productName // Include product name in the request
                })
            })
                .then(response => response.json())
                .then(data => {
                    // Update the global rating
                    const averageRating = parseFloat(data.average_rating); // toFixed yerine doğrudan parseFloat kullanıldı
                    globalRatingElement.textContent = averageRating;

                    // Update the stars
                    const fullStars = Math.floor(averageRating);
                    const partialStarWidth = (averageRating - fullStars) * 100;
                    starsContainer.innerHTML = '';

                    for (let i = 1; i <= 5; i++) {
                        if (i <= fullStars) {
                            starsContainer.innerHTML += `
            <div class="star-container">
                <i class="fa fa-star full-star"></i>
            </div>`;
                        } else if (i === fullStars + 1 && partialStarWidth > 0) {
                            starsContainer.innerHTML += `
            <div class="star-container">
                <i class="fa fa-star full-star"></i>
                <div class="partial-star" style="width: ${partialStarWidth}%;"></div>
            </div>`;
                        } else {
                            starsContainer.innerHTML += `
            <div class="star-container">
                <i class="fa fa-star"></i>
            </div>`;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error fetching global rating:', error);
                    alert('Failed to update global rating.');
                })
                .finally(() => {
                    // Hide loading animation
                    loading.classList.add('d-none');
                });
        });
    });
</script>
