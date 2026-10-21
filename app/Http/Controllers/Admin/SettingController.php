<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display settings and admin account configuration page.
     */
    public function index(): View
    {
        $settings = [
            'library_name' => Setting::get('library_name', 'Perpustakaan Digital BPS Kabupaten Jember'),
            'library_tagline' => Setting::get('library_tagline', 'Akses Publikasi Statistik Resmi, Data, dan Indikator Daerah'),
            'library_description' => Setting::get('library_description', 'Layanan perpustakaan digital resmi Badan Pusat Statistik Kabupaten Jember untuk mendukung riset, perencanaan pembangunan daerah, dan literasi data statistik bagi masyarakat, akademisi, dan instansi.'),
            'contact_address' => Setting::get('contact_address', 'Jl. Kartini No. 19, Kepatihan, Kec. Kaliwates, Kabupaten Jember, Jawa Timur 68131'),
            'contact_phone' => Setting::get('contact_phone', '(0331) 487532'),
            'contact_email' => Setting::get('contact_email', 'bps3509@bps.go.id'),
            'contact_whatsapp' => Setting::get('contact_whatsapp', '0812-3456-7890'),
            'service_hours' => Setting::get('service_hours', 'Senin – Kamis: 08.00 – 15.30 WIB | Jumat: 08.00 – 15.00 WIB'),
            'library_logo' => Setting::get('library_logo', 'assets/images/logo-bps.svg'),
        ];

        $currentAdmin = Auth::user();

        return view('admin.settings.index', compact('settings', 'currentAdmin'));
    }

    /**
     * Update library general settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'library_name' => ['required', 'string', 'max:255'],
            'library_tagline' => ['nullable', 'string', 'max:255'],
            'library_description' => ['nullable', 'string'],
            'contact_address' => ['nullable', 'string'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:100'],
            'contact_whatsapp' => ['nullable', 'string', 'max:50'],
            'service_hours' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:svg,png,jpg,jpeg,webp', 'max:2048'],
        ], [
            'library_name.required' => 'Nama perpustakaan wajib diisi.',
            'contact_email.email' => 'Format email kontak tidak valid.',
        ]);

        foreach ($validated as $key => $value) {
            if ($key !== 'logo' && ! is_null($value)) {
                Setting::set($key, (string) $value);
            }
        }

        if ($request->hasFile('logo')) {
            $logoDir = public_path('uploads/logos');
            if (! File::isDirectory($logoDir)) {
                File::makeDirectory($logoDir, 0755, true);
            }
            $logoFileName = 'library_logo_'.time().'.'.$request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move($logoDir, $logoFileName);
            Setting::set('library_logo', 'uploads/logos/'.$logoFileName);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan perpustakaan berhasil disimpan.');
    }

    /**
     * Update current logged in admin account.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $admin */
        $admin = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$admin->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'current_password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama admin wajib diisi.',
            'email.required' => 'Email admin wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->phone = $validated['phone'];

        if (! empty($validated['new_password'])) {
            if (empty($validated['current_password'])) {
                return back()->withErrors(['current_password' => 'Masukkan password saat ini untuk mengubah password.']);
            }

            if (! Hash::check($validated['current_password'], $admin->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini yang Anda masukkan salah.']);
            }

            $admin->password = Hash::make($validated['new_password']);
        }

        $admin->save();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Profil dan akun admin Anda berhasil diperbarui.');
    }
}
