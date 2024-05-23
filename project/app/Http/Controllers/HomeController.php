<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.layout.index');
    }
    public function home()
    {
        return view('home.layout.index');
    }
    public function about()
    {
        return view('home.layout.about');
    }

    public function cart()
    {
        return view('home.layout.cart');
    }

    public function category()
    {
        return view('home.layout.category');
    }
}
