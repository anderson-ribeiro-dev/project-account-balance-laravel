<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //home da administração
    public function index()
    {
        return view('admin.home.index');
    }
}
