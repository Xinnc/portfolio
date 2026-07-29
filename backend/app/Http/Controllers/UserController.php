<?php

namespace App\Http\Controllers;

use App\Actions\Review\StoreReviewAction;
use App\Actions\User\LoginAdminAction;
use App\DataTransferObjects\CreateSettingsData;
use App\DataTransferObjects\Review\StoreReviewData;
use App\DataTransferObjects\UpdateSettingsData;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function login(Request $request)
    {
        $token = LoginAdminAction::execute($request);
        return response()->json([
            'message' => 'Вы успешно авторизовались!',
            'token' => $token,
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->noContent(204);
    }

    public function settings()
    {
        return response()->json([
            'data' => Setting::get()
        ]);
    }

    public function updateSettings(UpdateSettingsData $data)
    {
        Setting::first()->update($data);

        return response()->json([
            'message' => 'Контактные данные успешно обновлены!'
        ]);
    }

    public function createSettings(CreateSettingsData $data){
        $fields = array_filter($data->all(), fn ($v) => !is_null($v) && $v !== '');
        Setting::updateOrCreate(['id' => 1], $fields);
        return response()->json([
            'message' => 'Контактные данные успешно изменены!'
        ]);
    }
}
