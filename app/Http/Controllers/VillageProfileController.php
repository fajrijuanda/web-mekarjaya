<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VillageProfileController extends Controller
{
    public function edit()
    {
        $profileContent = Setting::where('key', 'village_profile_content')->first();
        return Inertia::render('Admin/Profile/Edit', [
            'profileContent' => $profileContent ? $profileContent->value : ['blocks' => []],
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_content' => 'nullable|json',
        ]);

        $setting = Setting::firstOrNew(['key' => 'village_profile_content']);
        $setting->value = $request->profile_content;
        $setting->save();

        return redirect()->back()->with('success', 'Village Profile updated successfully.');
    }

    // Public show method
    public function show()
    {
        $profileContent = Setting::where('key', 'village_profile_content')->first();
        return Inertia::render('Profile/Show', [
            'profileContent' => $profileContent ? $profileContent->value : ['blocks' => []],
        ]);
    }
}