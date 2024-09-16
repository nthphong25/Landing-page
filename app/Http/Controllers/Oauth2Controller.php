<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Google_Client;
use Google_Service_Oauth2;
use Laravel\Socialite\Facades\Socialite;

class Oauth2Controller extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lý callback từ Google
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
      
        // Tìm hoặc tạo người dùng trong database
        $user = User::updateOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'email_verified_at' => now(),
        ]);

        // Đăng nhập người dùng
        Auth::login($user);
        // Điều hướng người dùng sau khi đăng nhập thành công
        return redirect()->route('dashboard');
    }
}
