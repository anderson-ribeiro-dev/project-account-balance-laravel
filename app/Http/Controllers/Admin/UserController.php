<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //método perfil
    public function profile(){
        return view('site.profile.profile');
    }
}