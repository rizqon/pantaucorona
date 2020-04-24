<?php

namespace App\Http\Controllers;

class KasusController extends Controller
{
    /**
     * Dashboard Controller
     *
     * @return View
     */
    public function index()
    {
        return view('dashboard');
    }
}