<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\UserRating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function rateProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_rate' => 'required|integer|min:1|max:5',
        ]);

        $userId = Auth::id();

        // Eğer değerlendirme varsa güncelle, yoksa yeni kayıt oluştur
        UserRating::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $request->product_id],
            ['user_rate' => $request->user_rate]
        );

        // Güncellenmiş site_rating ortalamasını hesapla ve formatla
        $newSiteRating = number_format((float) UserRating::where('product_id', $request->product_id)->avg('user_rate'), 1, '.', '');

        // Ürün kaydını güncelle
        Product::where('id', $request->product_id)->update(['site_rating' => $newSiteRating]);

        // Yeni site_rating değerini döndür
        return response()->json(['success' => true, 'new_site_rating' => $newSiteRating]);
    }

    public function removeRating(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::id();

        // Belirtilen ürün için kullanıcıya ait değerlendirmeyi sil
        UserRating::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->delete();

        // Güncellenmiş site_rating ortalamasını hesapla ve formatla
        $newSiteRating = number_format((float) UserRating::where('product_id', $request->product_id)->avg('user_rate'), 1, '.', '');

        // Ürün kaydını güncelle
        Product::where('id', $request->product_id)->update(['site_rating' => $newSiteRating ?? 0]);

        return response()->json(['success' => true, 'message' => 'Rating removed successfully!', 'new_site_rating' => $newSiteRating]);
    }

}
