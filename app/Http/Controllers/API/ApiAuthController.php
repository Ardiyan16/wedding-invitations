<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $cek = User::where('email', $email)->first();
        if(!$cek || !Hash::check($password, $cek->password)) {
            return response([
                'success' => false,
                'message' => 'Email atau Password yang anda masukkan salah'
            ]);
        }

        $redirect = '/admin-wedding';
        return response([
            'success' => true,
            'redirect' => $redirect,
            'message' => 'Anda berhasil masuk, akan dialihkan dalam 3 detik!',
            'remember_token' => $cek->remember_token
        ]);
    }
}
