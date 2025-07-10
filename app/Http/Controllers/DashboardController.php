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
        // --- Fungsi Helper yang lebih canggih ---
        $get_stats_data = function ($model, $dateColumn = 'created_at', $typeFilter = null) {
            // Data 7 hari terakhir (minggu ini)
            $thisWeekCount = $model::whereBetween($dateColumn, [Carbon::today()->subDays(6), Carbon::now()])
                ->when($typeFilter, fn($query) => $query->where('type', $typeFilter))
                ->count();

            // Data 7 hari sebelumnya (minggu lalu)
            $lastWeekCount = $model::whereBetween($dateColumn, [Carbon::today()->subDays(13), Carbon::today()->subDays(7)])
                ->when($typeFilter, fn($query) => $query->where('type', 'masuk'))
                ->count();

            // Hitung persentase fluktuasi
            if ($lastWeekCount > 0) {
                $fluctuation = (($thisWeekCount - $lastWeekCount) / $lastWeekCount) * 100;
            } else {
                // Jika minggu lalu 0, anggap pertumbuhan 100% jika ada data baru
                $fluctuation = $thisWeekCount > 0 ? 100 : 0;
            }

            // Data series untuk grafik
            $series = collect(range(6, 0))->map(function ($day) use ($model, $dateColumn, $typeFilter) {
                $date = Carbon::today()->subDays($day);
                return $model::whereDate($dateColumn, $date)
                    ->when($typeFilter, fn($query) => $query->where('type', $typeFilter))
                    ->count();
            });

            return [
                'total' => $model::when($typeFilter, fn($query) => $query->where('type', $typeFilter))->count(),
                'series' => $series,
                'fluctuation' => round($fluctuation, 1)
            ];
        };

        $stats = [
            'articles' => $get_stats_data(new Article),
            'residents' => $get_stats_data(new Resident),
            'users' => $get_stats_data(new User),
            'letters' => $get_stats_data(new Letter, 'letter_date', 'masuk'),
        ];
        $recentArticles = Article::with('user:id,name')->latest()->take(3)->get();

        $recentLetters = Letter::latest('letter_date')->take(3)->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentArticles' => $recentArticles,
            'recentLetters' => $recentLetters,
        ]);
    }
}