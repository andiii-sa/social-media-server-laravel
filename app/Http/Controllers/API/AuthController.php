<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Failed Validation', 400);
            }

            $findUser = User::where('email', strtolower($request->email))->first();
            if (!$findUser) {
                return ResponseFormatter::error(null, 'Data not found', 404);
            }

            if (!Hash::check($request->password, $findUser->password)) {
                return ResponseFormatter::error(null, 'Invalid Email/Password', 404);
            }

            $token = JWTAuth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ]);


            $feed = [
                "id" => $findUser->id,
                "username" => $findUser->username,
                "email" => $findUser->email,
                "name" => $findUser->name,
                "photo" => $findUser->photo,
                "is_verification" => $findUser->is_verification,
                "role" => $findUser->role,
                'token' => $token,
            ];

            return ResponseFormatter::success($feed, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function register(Request $request)
    {
        $rules = [
            'email' => 'required|string',
            'password' => 'required|string',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Failed Validation', 400);
            }

            $findCategory = User::where('name', strtolower($request->name))->first();
            if ($findCategory) {
                return ResponseFormatter::error(null, 'Data already exists', 400);
            }

            $category = User::create([
                'name' => $request->name,
            ]);

            return ResponseFormatter::success($category, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }

    public function detailToken()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return ResponseFormatter::success($user, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Wrong', 500);
        }
    }
}
