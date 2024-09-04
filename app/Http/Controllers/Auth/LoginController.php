<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;

use Socialite; // 導入 Socialite

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // 添加以下方法

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        // 邏輯：查找用户、創建用户或登入用户
        // 比如：使用 email 查找用户
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            auth()->login($existingUser);
        } else {
            // 如果用户不存在，創建一个新用户
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id, // 假設你在 users 表中添加了 google_id 字段
                // 可以為用户設置一个隨機密碼，或者不設置密碼
                'password' => bcrypt('random_password'),
            ]);

            auth()->login($newUser);
        }

        return redirect()->intended('/home'); // 登入後重定向到你想要的頁面
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        // 邏輯：查找用户、創建用户或登录用户
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            auth()->login($existingUser);
        } else {
            // 如果用户不存在，創建一个新用户
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'facebook_id' => $user->id, // 假設你在 users 表中添加了 facebook_id 字段
                // 可以為用户設置一个隨機密码，或者不設置密碼
                'password' => bcrypt('random_password'),
            ]);

            auth()->login($newUser);
        }

        return redirect()->intended('/home'); // 登入後重定向到你想要的頁面
    }
}
