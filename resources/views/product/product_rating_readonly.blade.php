<style>
    .ratings {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }

    .ratings i {
        color: floralwhite;
        font-size: 15px;
    }

    .rating-color {
        color: #fbc634 !important;
    }

    .review-stat {
        font-weight: 300;
        font-size: 18px;
        margin-bottom: 2px;
    }

</style>

<!-- RFE Rating -->
<div class="d-flex justify-content-between align-items-center">
    <h5 class="review-stat fw-medium">RFE Rating:</h5>
    <div class="ratings">
        <span class="fw-bold p-2">{{ number_format($product->site_rating, 1) }}</span>
        @php
            $site_rating = round($product->site_rating); // 5 üzerinden yuvarlanan değer
        @endphp
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa fa-star {{ $i <= $site_rating ? 'rating-color' : '' }}"></i>
        @endfor

    </div>
</div>

<!-- Global Rating -->
<div class="mt-1 d-flex justify-content-between align-items-center">
    <h5 class="review-stat fw-medium">Global Rating:</h5>
    <div class="ratings">
        @php
            // Eğer tam sayı ise .00 göstermeden yaz, değilse uygun formatla
            $globalRating = (intval($product->global_rating) == $product->global_rating)
                ? intval($product->global_rating) // Tam sayıysa
                : (round($product->global_rating, 2) == round($product->global_rating, 1) ? round($product->global_rating, 1) : number_format($product->global_rating, 2)); // Değilse uygun yuvarlama

            $full_stars = floor($product->global_rating); // Tam yıldız sayısı
            $has_half_star = ($product->global_rating - $full_stars) >= 0.5; // Yarım yıldız var mı
            $empty_stars = 5 - $full_stars - ($has_half_star ? 1 : 0); // Gri yıldız sayısı
        @endphp
        <span class="fw-bold p-2">{{ $globalRating }}</span>

        <!-- Tam Yıldızlar -->
        @for ($i = 1; $i <= $full_stars; $i++)
            <i class="fa fa-star rating-color"></i>
        @endfor

        <!-- Yarım Yıldız -->
        @if ($has_half_star)
            <i class="fa fa-star-half-alt rating-color"></i>
        @endif

        <!-- Gri Yıldızlar -->
        @for ($i = 1; $i <= $empty_stars; $i++)
            <i class="fa fa-star"></i>
        @endfor
    </div>
</div>
