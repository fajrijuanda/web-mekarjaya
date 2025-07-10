<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VillageProfileController extends Controller
{
    /**
     * Menampilkan halaman profil desa untuk publik.
     */
    public function show()
    {
        $settings = Setting::pluck('value', 'key');
        return Inertia::render('Public/ProfileShow', ['settings' => $settings]);
    }

    /**
     * Menampilkan form edit profil desa untuk admin.
     */
    public function edit()
    {
        $settings = Setting::pluck('value', 'key');
        return Inertia::render('Admin/ProfileEdit', ['settings' => $settings]);
    }

    /**
     * Menyimpan perubahan dari form edit.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'village_history' => 'nullable|string',
            'village_vision' => 'nullable|string',
            'village_mission' => 'nullable|string',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Profil Desa berhasil diperbarui.');
    }
}