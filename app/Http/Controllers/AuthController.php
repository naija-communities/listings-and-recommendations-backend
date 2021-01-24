<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register()
    {
        dd("registering");
    }

    public function login()
    {
        dd("loggin in");
    }

    public function logout()
    {
        dd("logging out");
    }
}
