<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function getApp(){
        return view('layouts.app');
    }

    public function getLogin(){
        return view('auth.login');
    }
}
