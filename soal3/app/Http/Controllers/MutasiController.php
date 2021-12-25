<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MutasiController extends Controller
{
    /**
     * Mutasi Index
     * @return /Illumniate/Http/Response
     */

    public function index()
    {
        $mutations = auth()->user()
            ->transactions()
            ->where('status', 'PAID')
            ->latest()
            ->get();
        return view('mutasi.index', compact('mutations'));
    }
}
