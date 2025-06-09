<?php

namespace App\Http\Controllers\Pengguna;

use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Routing\Controller;

class RatingController extends Controller
{
   public function simpan(Request $request)
{
    $validated = $request->validate([
        'order_id' => 'required|exists:orders,order_id',
        'user_id' => 'required|exists:users,id',
        'star_rating' => 'required|integer|min:1|max:5',
    ]);

    try {
        Rating::updateOrCreate(
            ['order_id' => $validated['order_id'], 'user_id' => $validated['user_id']],
            ['star_rating' => $validated['star_rating']]
        );

        return response()->json([
            'success' => true,
            'message' => 'Rating berhasil disimpan.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan rating: ' . $e->getMessage()
        ], 500);
    }
}
}
