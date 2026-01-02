<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Contracts\View\View;

class GalleriesController extends Controller
{
    /**
     * Display a listing of the galleries.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        // Fetch all galleries from the database
        $galleries = Gallery::with('media')->get();

        return view('galleries.index', ['galleries' => $galleries]);
    }
}
