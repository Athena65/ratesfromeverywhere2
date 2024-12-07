<style>
    .ratings {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }

    .ratings i {
        color: #cecece;
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
        <span class="fw-bold p-2">{{ number_format($product->global_rating, 1) }}</span>
        @php
            $global_rating = round($product->global_rating); // 5 üzerinden yuvarlanan değer
        @endphp
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa fa-star {{ $i <= $global_rating ? 'rating-color' : '' }}"></i>
        @endfor
    </div>
</div>

