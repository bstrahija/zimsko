<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleriesController extends Controller
{
    public function index()
    {
        return view('galleries.index');
    }
}
