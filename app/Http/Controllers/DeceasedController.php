<?php

namespace App\Http\Controllers;

use App\User; // Pastikan ini benar
use Illuminate\Http\Request;

class DeceasedController extends Controller
{
   public function index()
    {
        // Ambil semua user yang sudah meninggal (tidak peduli seberapa jauh selisih tahunnya)
        $deceasedUsers = User::where(function ($query) {
    $query->whereNotNull('dod')
          ->orWhereNotNull('yod');
})
->with(['father', 'mother', 'children'])
->orderByRaw("COALESCE(dod, CONCAT(yod, '-01-01')) ASC")
->paginate(50); // Batasi 50 data per halaman
    
        // Kirim data ke view
        return view('deceased.index', compact('deceasedUsers'));
    }
}