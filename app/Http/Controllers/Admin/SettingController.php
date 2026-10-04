<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // Menampilkan halaman form pengaturan
    public function index()
    {
        // Ambil data pengaturan pertama, jika kosong buat instance baru
        $setting = Setting::first() ?? new Setting;

        return view('admin.settings.index', compact('setting'));
    }

    // Memperbarui pengaturan
    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'bank_account' => 'nullable|string',
            'store_info' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $setting = Setting::first();

        // Jika belum ada data pengaturan sama sekali, buat baru
        if (! $setting) {
            $setting = new Setting;
        }

        // Proses Upload Logo
        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $setting->logo = $request->file('logo')->store('settings', 'public');
        }

        // Proses Upload QRIS
        if ($request->hasFile('qris_image')) {
            if ($setting->qris_image) {
                Storage::disk('public')->delete($setting->qris_image);
            }
            $setting->qris_image = $request->file('qris_image')->store('settings', 'public');
        }

        // Update sisa data
        $setting->store_name = $validated['store_name'];
        $setting->whatsapp = $validated['whatsapp'];
        $setting->email = $validated['email'];
        $setting->bank_account = $validated['bank_account'];
        $setting->store_info = $validated['store_info'];

        $setting->save();

        return redirect()->back()->with('success', 'Pengaturan toko berhasil diperbarui!');
    }
}
