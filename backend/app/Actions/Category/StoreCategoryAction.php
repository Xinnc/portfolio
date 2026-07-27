<?php

namespace App\Actions\Category;

use App\DataTransferObjects\category\StoreCategoryData;
use App\Models\Category;

class StoreCategoryAction
{
    public static function execute(StoreCategoryData $data)
    {
        $path = $data->cover_image->store('category/cover_image', 'public');
        $category = Category::create([
            'title' => $data->title,
            'description' => $data->description,
            'cover_image' => $path,
            'slug' => $data->slug,
            'sort_order' => $data->sort_order,
        ]);
        return $category;
    }
}
