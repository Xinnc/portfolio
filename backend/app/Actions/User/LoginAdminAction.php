<?php

namespace App\Actions\User;

use App\Exceptions\ValidationFailedException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginAdminAction
{
    public static function execute(Request $request){
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)) throw new ValidationFailedException();
        $token = $user->createToken('admin-token')->plainTextToken;
        return $token;
    }
}
