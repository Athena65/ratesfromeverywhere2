<?php

namespace App\Observers;

use App\Models\UserRating;
use App\Models\Product;

class UserRatingObserver
{
    // Yeni bir user_rate eklendiğinde veya var olan güncellendiğinde tetiklenir
    public function saved(UserRating $userRating)
    {
        // İlgili ürünün tüm user_rate ortalamasını hesapla
        $averageRating = UserRating::where('product_id', $userRating->product_id)->avg('user_rate');

        // Ürünün site_rating alanını güncelle
        Product::where('id', $userRating->product_id)->update(['site_rating' => $averageRating]);
    }

    // Bir user_rate silindiğinde tetiklenir
    public function deleted(UserRating $userRating)
    {
        // İlgili ürünün tüm user_rate ortalamasını tekrar hesapla
        $averageRating = UserRating::where('product_id', $userRating->product_id)->avg('user_rate');

        // Ürünün site_rating alanını güncelle
        Product::where('id', $userRating->product_id)->update(['site_rating' => $averageRating]);
    }
}
