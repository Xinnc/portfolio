<?php

namespace App\Http\Controllers;

use App\Actions\Review\StoreReviewAction;
use App\Actions\Review\UpdateReviewAction;
use App\DataTransferObjects\Review\StoreReviewData;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, StoreReviewData $data)
    {
        StoreReviewAction::execute($request, $data);

        return response()->json([
            'message' => 'Отзыв отпралвен!',
        ]);
    }

    public function index()
    {
        return response()->json([
            'data' => Review::where('status', 'accepted')->get(),
        ]);
    }

    public function indexAll()
    {
        $query = Review::query();

        if (request()->has('status')) {
            $query->where('status', request()->query('status'));
        }

        $reviews = $query->get();

        return response()->json([
            'data' => $reviews,
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $review = UpdateReviewAction::execute($request, $review);
        return response()->json([
            'message' => 'Статус отзыва успешно обновлен!',
            'review' => $review,
        ]);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return response()->noContent(204);
    }
}
