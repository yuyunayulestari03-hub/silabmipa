<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $settings = Setting::pluck('value', 'key')->all();
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'app_name' => 'nullable|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->filled('app_name')) {
            Setting::updateOrCreate(
                ['key' => 'app_name'],
                ['value' => $request->app_name]
            );
        }

        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('public/settings');
            // Storage::url($path) usually returns /storage/settings/filename.ext
            // We need to ensure 'public/settings' is accessible via symlink or simple logic
            
            // Clean up old logo if needed, but for now just update
            
            $url = Storage::url($path);
            
            Setting::updateOrCreate(
                ['key' => 'app_logo'],
                ['value' => $url]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
