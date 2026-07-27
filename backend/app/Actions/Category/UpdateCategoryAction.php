<?php

namespace App\Actions\Category;

use App\DataTransferObjects\category\UpdateCategoryData;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class UpdateCategoryAction
{
    public static function execute(UpdateCategoryData $data, Category $category): Category
    {
        $updates = $data->getFilledFields();
        if($data->cover_image) {
            if($category->cover_image && Storage::disk('public')->exists($category->cover_image)) {
                Storage::disk('public')->delete($category->cover_image);
            }

            $path = $data->cover_image->store('category/cover_image', 'public');
            $updates['cover_image'] = $path;
        }

        if(!empty($updates)) {
            $category->update($updates);
        }

        return $category;
    }
}
