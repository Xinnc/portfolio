<?php

namespace App\Http\Controllers;

use App\Actions\Category\StoreCategoryAction;
use App\Actions\Category\UpdateCategoryAction;
use App\DataTransferObjects\category\StoreCategoryData;
use App\DataTransferObjects\category\UpdateCategoryData;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class CategoryController extends Controller
{
    //Если надо будет, докрутим пагинацию, поиск, фильтрацию.

    public function index()
    {
        return response()->json([
            'data' => Category::where('sort_order', '>', 0)->orderBy('sort_order', 'asc')->get(),
        ]);
    }

    public function indexAll()
    {
        return response()->json([
            'data' => Category::all()
        ]);
    }

    public function store(StoreCategoryData $data)
    {
        $category = StoreCategoryAction::execute($data);
        return response()->json([
            'message' => 'Категория успешно создана!',
            'data' => $category
        ], 201);
    }

    public function update(UpdateCategoryData $data, Category $category)
    {
        $category = UpdateCategoryAction::execute($data, $category);
        return response()->json([
            'message' => 'Категории успешно обновлены!',
            'data' => $category
        ]);
    }

    public function destroy(Category $category)
    {
        if($category->cover_image && Storage::disk('public')->exists($category->cover_image)) {
            Storage::disk('public')->delete($category->cover_image);
        }
        $category->delete();
        return response()->noContent(204);
    }

}
