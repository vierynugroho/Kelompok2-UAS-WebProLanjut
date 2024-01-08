<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Literation;
use App\Models\Pinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $datas = Book::all();
        return view('home', [
            'datas' => $datas,

        ]);
    }

    public function dashboard()
    {
        $user = auth()->user();

        // user information
        $count_pinjam_user = Pinjam::where('id_user', $user->nik)->count();
        $count_literasi_user = Literation::where('id_user', $user->nik)->count();
        $rank_user = Literation::select('id_user', DB::raw('count(*) as jumlah_literasi'))
            ->groupBy('id_user')
            ->orderByDesc('jumlah_literasi')
            ->pluck('id_user')
            ->search($user->nik);

        // admin information
        $count_buku = Book::all()->count();
        $count_pinjam = Pinjam::all()->count();
        $count_literasi = Literation::all()->count();
        $leaderboards = Literation::select('id_user', DB::raw('count(*) as jumlah_literasi'))
            ->groupBy('id_user')
            ->orderBy('jumlah_literasi', 'DESC')
            ->get();

        return view('pages.dashboard', [
            // admin information
            'count_pinjam' => $count_pinjam,
            'count_literasi' => $count_literasi,
            'count_buku' => $count_buku,
            'leaderboards' => $leaderboards,

            // user information
            'rank_user' => $rank_user + 1,
            'count_literasi_user' => $count_literasi_user,
            'count_pinjam_user' => $count_pinjam_user
        ]);
    }
}
