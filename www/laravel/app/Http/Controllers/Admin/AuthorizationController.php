<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class AuthorizationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'account' => ['required'],
            'password' => 'required|string|max:16',
        ], [], [
            'account' => '账号',
            'password' => '密码',
        ]);

        $data = $request->only(['account','password']);

        if (Auth::validate($data)) {
            $user = User::where('account', $data['account'])->first(['id', 'nickname', 'phone', 'gender', 'avatar', 'email']);

            $user['token'] = $user->createToken('auth')->plainTextToken;

            return response()->json($user);
        } else {
            return response()->json(['message' => '账号或密码错误'], 403);
        }
    }

    public function getUserInfo(Request $request)
    {
        $user = $request->user();

        $user = $user->only(['id', 'nickname', 'phone', 'gender', 'avatar', 'email']);

        return response()->json($user);
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|max:16',
            'captcha_code' => 'required|string',
            'captcha_key' => 'required|string',
        ], [

        ], [
            'password' => '密码',
            'captcha_code' => '验证码',
            'captcha_key' => '验证码',
        ]);

        $password = $request->password;

        $captchaData = Cache::get('captcha_' . $request->captcha_key);
        if (!$captchaData) {
            return response()->json(['message' => '验证码已失效'], 403);
        }

        if (!hash_equals($captchaData['code'], strtolower($request->captcha_code))) {
            // 验证错误就清除缓存
            // Cache::forget('captcha_' . $request->captcha_key);
            return response()->json(['message' => '验证码错误'], 403);
        }
        Cache::forget('captcha_' . $request->captcha_key);

        $password = Hash::make($password);

        $result = ($request->user())->update(['password' => $password]);

        return response()->json($result);
    }
}
