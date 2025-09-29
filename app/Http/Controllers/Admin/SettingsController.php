<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $setting = DB::table('settings')->where('key', 'active_test_phase')->first();
        $activePhase = $setting->value ?? 'pre'; // Default to 'pre' if not set

        return view('admin.settings', ['activePhase' => $activePhase]);
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'active_phase' => 'required|in:pre,post',
        ]);

        DB::table('settings')->updateOrInsert(
            ['key' => 'active_test_phase'],
            ['value' => $request->active_phase, 'updated_at' => now()]
        );

        return redirect()->route('admin.settings.index')->with('success', 'تم تحديث الإعدادات بنجاح.');
    }
}
