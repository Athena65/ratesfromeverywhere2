<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

// for post request
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
        $newSiteRating = number_format((float)UserRating::where('product_id', $request->product_id)->avg('user_rate'), 1, '.', '');

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
        $newSiteRating = number_format((float)UserRating::where('product_id', $request->product_id)->avg('user_rate'), 1, '.', '');

        // Ürün kaydını güncelle
        Product::where('id', $request->product_id)->update(['site_rating' => $newSiteRating ?? 0]);

        return response()->json(['success' => true, 'message' => 'Rating removed successfully!', 'new_site_rating' => $newSiteRating]);
    }

    public function checkUserRating(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::id();

        // Kullanıcının ürüne değerlendirme yapıp yapmadığını kontrol et
        $userRatingExists = UserRating::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->exists();

        return response()->json(['rated' => $userRatingExists]);
    }

    // Genel değerlendirme bilgilerini al
    public function getGlobalRating(Request $request)
    {
        $productName = $request->input('product_name');
        $productId = $request->input('product_id'); // Ensure product ID is included in the request

        try {
            // 90 saniyelik timeout ile API çağrısı
            $response = Http::timeout(90)->post('http://127.0.0.1:5000/get_global_rating', [
                'product_name' => $productName,
            ]);

            if ($response->successful()) {
                $allRatings = $response->json();
                $totalRating = 0;
                $count = 0;

                foreach ($allRatings as $ratingInfo) {
                    if (isset($ratingInfo['rating'])) {
                        // Virgüllü formatı noktaya çevir ve float olarak al
                        $rating = floatval(str_replace(',', '.', $ratingInfo['rating']));
                        $totalRating += $rating;
                        $count++;
                    }
                }

                // Ortalama hesapla
                $averageRating = $count > 0 ? $totalRating / $count : 0;

                // Update the product's global rating in the database
                $product = Product::findOrFail($productId);
                $product->global_rating = number_format($averageRating, 2);
                $product->save();

                return response()->json([
                    'average_rating' => number_format($averageRating, 2), // Ondalıklı formatta döndür
                ]);
            }

            return response()->json(['average_rating' => 'Henüz değerlendirilmemiş'], 200);
        } catch (\Exception $e) {
            \Log::error("Error fetching global rating: " . $e->getMessage());

            // Ürünün mevcut global_rating değerini döndür
            $product = Product::find($productId);
            $currentRating = $product->global_rating;

            return response()->json(['average_rating' => $currentRating]);
        }

    }

}
