<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class UserController extends Controller
{
    // UserDashboardController.php
    public function index()
    {
        // Mengambil semua barang (bisa ditambah pagination nanti)
        $barang = Barang::all(); 
        return view('Dashboard', compact('barang'));
    }
}


