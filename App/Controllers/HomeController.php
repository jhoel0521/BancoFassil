<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', ['title' => traducir('Bienvenido')]);
    }
    public function services()
    {
        return view('home.services', ['title' => traducir('servicios')]);
    }
}
