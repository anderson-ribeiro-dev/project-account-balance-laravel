<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;//chama a classe

class SiteController extends Controller
{
    //chama a view index
    public function index()
    {
      return view('site.home.index');
    }
}
