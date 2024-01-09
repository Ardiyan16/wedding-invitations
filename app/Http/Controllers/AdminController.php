<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AdminController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        Cookie::queue(Cookie::forget('ALD_SESSION'));
        return redirect()->route('login');
    }

    public function index()
    {
        $var['title'] = 'Dashboard';
        return view('admin.dashboard', $var);
    }

    public function template()
    {
        $var['title'] = 'Template';
        return view('admin.template', $var);
    }

    public function pengantin()
    {
        $var['title'] = 'Pengantin';
        return view('admin.pengantin', $var);
    }

    public function bank()
    {
        $var['title'] = 'Bank';
        return view('admin.bank', $var);
    }

}
