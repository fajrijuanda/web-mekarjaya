<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Letter;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     */
    public function index()
    {
        // --- Fungsi Helper untuk mengambil data 7 hari terakhir ---
        $get_daily_data = function ($model) {
            return collect(range(6, 0))->map(function ($day) use ($model) {
                return $model::whereDate('created_at', Carbon::today()->subDays($day))->count();
            });
        };

        // --- Siapkan data untuk setiap kartu ---
        $stats = [
            'articles' => [
                'total' => Article::count(),
                'series' => $get_daily_data(new Article),
            ],
            'residents' => [
                'total' => Resident::count(),
                'series' => $get_daily_data(new Resident),
            ],
            'users' => [
                'total' => User::count(),
                'series' => $get_daily_data(new User),
            ],
            'letters' => [
                'total' => Letter::where('type', 'masuk')->count(),
                'series' => Letter::where('type', 'masuk')
                    ->select(DB::raw('count(*) as count, date(letter_date) as date'))
                    ->where('letter_date', '>=', Carbon::today()->subDays(6))
                    ->groupBy('date')
                    ->get()
                    ->pluck('count'),
            ]
        ];

        $recentArticles = Article::with('user:id,name')->latest()->take(5)->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentArticles' => $recentArticles,
        ]);
    }
}