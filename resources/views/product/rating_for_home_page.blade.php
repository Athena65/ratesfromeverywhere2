<style>
    .ratings {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }

    .ratings i {
        color: #cecece; /* Gri renk pasif yıldızlar için */
        font-size: 15px; /* Yıldız boyutu */
        margin-left: 2px; /* Yıldızlar arası boşluk */
    }

    .rating-color {
        color: #fbc634 !important; /* Sarı renk aktif yıldızlar için */
    }

    .review-stat {
        font-weight: 300;
        font-size: 18px;
        margin-bottom: 2px;
    }

    .fw-bold {
        font-weight: bold;
    }

    .p-2 {
        padding: 0 5px;
    }
</style>
<!-- RFE Rating -->


<div class="d-flex flex-column align-items-start mb-3">
    <!-- Başlıklar Aynı Satırda -->
    <div class="d-flex justify-content-between align-items-center w-100">
        <!-- RFE Rating Başlığı -->
        <h5 class="review-stat fw-medium me-4">{{ __('messages.rfe_rating') }}:</h5>
        <!-- Your Rating Başlığı -->
        <h5 class="review-stat fw-medium">{{ __('messages.your_rating') }}:</h5>
    </div>

    <!-- Altlarında Yıldızlar ve Değerler -->
    <div class="d-flex justify-content-between align-items-start w-100 mt-2">
        <!-- RFE Rating Yıldızlar -->
        <div class="ratings d-flex align-items-center">
            <span class="fw-bold p-2">{{ number_format($product->site_rating, 1) }}</span>
            @php
                $site_rating = round($product->site_rating); // 5 üzerinden yuvarlanan değer
            @endphp
            @for ($i = 1; $i <= 5; $i++)
                <i class="fa fa-star {{ $i <= $site_rating ? 'rating-color' : '' }}"></i>
            @endfor
        </div>

        <!-- Your Rating Yıldızlar ve Modal -->
        <div class="user-rating px-2 py-1 d-flex align-items-center"
             data-product-id="{{ $product->id }}"
             onclick="openRatingModal('{{ $product->name }}', {{ $product->id }})">
            @if($product->user_rating)
                <i class="fas fa-star me-1" style="color: #1e73be;"></i>
                <span class="fw-bold">{{ $product->user_rating }}/5</span>
            @else
                <i class="far fa-star me-1"></i> Rate
            @endif
        </div>
    </div>
</div>


<!-- Global Rating -->
<div class="d-flex justify-content-between align-items-center">
    <h5 class="review-stat fw-medium">Global Rating:</h5>
    <div class="ratings">
        @php
            // Eğer tam sayı ise .00 göstermeden yaz, değilse uygun formatla
            $globalRating = (intval($product->global_rating) == $product->global_rating)
                ? intval($product->global_rating) // Tam sayıysa
                : (round($product->global_rating, 2) == round($product->global_rating, 1) ? round($product->global_rating, 1) : number_format($product->global_rating, 2)); // Değilse uygun yuvarlama
        @endphp
        <span class="fw-bold p-2">{{ $globalRating }}</span>

        @php
            $global_rating = round($product->global_rating); // 5 üzerinden yuvarlanan değer
        @endphp
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa fa-star {{ $i <= $global_rating ? 'rating-color' : '' }}"></i>
        @endfor
    </div>
</div>
