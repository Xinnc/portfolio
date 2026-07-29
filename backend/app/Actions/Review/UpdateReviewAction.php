<?php

namespace App\Actions\Review;

use App\DataTransferObjects\Review\StoreReviewData;
use App\Exceptions\ValidationFailedException;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UpdateReviewAction
{
    public static function execute(Request $request, Review $review)
    {
        $review->update([
            'status' => $request->status,
        ]);
        return $review;
    }
}
