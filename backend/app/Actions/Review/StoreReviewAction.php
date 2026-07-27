<?php

namespace App\Actions\Review;

use App\DataTransferObjects\Review\StoreReviewData;
use App\Exceptions\ValidationFailedException;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreReviewAction
{
    public static function execute(Request $request, StoreReviewData $data)
    {
        $ip = $request->ip();

        $lastReview = Review::where('ip_address', $ip)->where('created_at', '>=', Carbon::now()->subDay())->first();
        if ($lastReview) {
            throw new ValidationFailedException(422, 'Вы уже оставляли отзыв за последние 24 часа. Пожалуйста, попробуйте позже.',);
        }

        Review::create([
            'title' => $data->title,
            'description' => $data->description,
            'name' => $data->name,
            'ip_address' => $ip,
            'status' => 'pending'
        ]);
    }
}
