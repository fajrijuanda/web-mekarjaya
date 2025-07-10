<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Letter;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $get_stats_data = function ($model, $dateColumn = 'created_at', $typeFilter = null) {
            $thisWeekCount = $model::whereBetween($dateColumn, [Carbon::today()->subDays(6), Carbon::now()])
                ->when($typeFilter, fn($query) => $query->where('type', $typeFilter))
                ->count();

            $lastWeekCount = $model::whereBetween($dateColumn, [Carbon::today()->subDays(13), Carbon::today()->subDays(7)])
                ->when($typeFilter, fn($query) => $query->where('type', $typeFilter))
                ->count();

            // --- LOGIKA FLUKTUASI YANG SEPENUHNYA DIPERBAIKI ---
            $fluctuation = 0;
            if ($lastWeekCount > 0) {
                // Kasus 1: Ada data minggu lalu, kita bisa bandingkan.
                $fluctuation = (($thisWeekCount - $lastWeekCount) / $lastWeekCount) * 100;
            } elseif ($thisWeekCount > 0) {
                // Kasus 2: Minggu lalu 0, tapi minggu ini ada data -> Pertumbuhan baru.
                $fluctuation = 100;
            }
            // Kasus 3: Jika kedua minggu 0, fluctuation akan tetap 0 (default).

            // --- Aturan Kustom Sesuai Permintaan ---
            // Jika tidak ada penambahan sama sekali minggu ini (turun menjadi 0),
            // anggap sebagai 0%, bukan -100%.
            if ($thisWeekCount === 0 && $lastWeekCount > 0) {
                $fluctuation = 0;
            }


            $series = collect(range(6, 0))->map(function ($day) use ($model, $dateColumn, $typeFilter) {
                $date = Carbon::today()->subDays($day);
                return $model::whereDate($dateColumn, $date)
                    ->when($typeFilter, fn($query) => $query->where('type', $typeFilter))
                    ->count();
            });

            return [
                'total' => $model::when($typeFilter, fn($query) => $query->where('type', 'masuk') && $model->getTable() === 'letters' ? $query->where('type', 'masuk') : $query)->count(),
                'series' => $series,
                'fluctuation' => round($fluctuation, 1)
            ];
        };

        // ... (sisa kode tetap sama)
        $stats = [
            'articles' => $get_stats_data(new Article),
            'residents' => $get_stats_data(new Resident),
            'users' => $get_stats_data(new User),
            'letters' => $get_stats_data(new Letter, 'letter_date', 'masuk'),
        ];

        $recentArticles = Article::with('user:id,name')->latest()->take(4)->get();
        $recentLetters = Letter::latest('letter_date')->take(4)->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentArticles' => $recentArticles,
            'recentLetters' => $recentLetters,
        ]);
    }
}