<?php

namespace App\Http\Controllers;

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

        // Eğer değerlendirme varsa güncelle, yoksa yeni kayıt oluştur (uesr_rates tablosuna)
        $rating = UserRating::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $request->product_id],
            ['user_rate' => $request->user_rate]
        );

        return response()->json(['success' => true, 'message' => 'Rating saved successfully!']);
    }
    // rati i kaldirmak için
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

        return response()->json(['success' => true, 'message' => 'Rating removed successfully!']);
    }
}
