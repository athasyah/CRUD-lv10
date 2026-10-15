<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Companion;
use App\Models\Expense;
use App\Models\Trip;
use Illuminate\Http\Request;
use Symfony\Component\Console\Descriptor\Descriptor;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jumlahrekan = Companion::count();
        $jumlahdestinasi = Destination::count();
        $jumlahtrip = Trip::count();
        $totalPengeluaran = Expense::sum('amount'); // Menjumlahkan semua pengeluaran
        return view('home', compact('totalPengeluaran','jumlahtrip','jumlahdestinasi','jumlahrekan'));
    }
}
