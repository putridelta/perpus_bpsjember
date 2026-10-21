<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle login authentication.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->status !== 'active') {
                Auth::logout();

                return back()->withInput($request->only('email'))
                    ->withErrors(['email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi superadmin.']);
            }

            if ($user->role !== 'admin') {
                Auth::logout();

                return back()->withInput($request->only('email'))
                    ->withErrors(['email' => 'Akses ditolak. Anda tidak memiliki izin sebagai admin.']);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, '.$user->name.'!');
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.']);
    }

    /**
     * Quick demo login for instant convenience.
     */
    public function quickDemoLogin(Request $request): RedirectResponse
    {
        $admin = User::where('role', 'admin')->where('status', 'active')->first();

        if (! $admin) {
            $admin = User::firstOrCreate(
                ['email' => 'admin@bps.go.id'],
                [
                    'name' => 'Admin Perpustakaan BPS',
                    'password' => bcrypt('password123'),
                    'role' => 'admin',
                    'status' => 'active',
                ]
            );
        }

        Auth::login($admin);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Berhasil masuk sebagai Admin: '.$admin->name);
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil keluar dari sistem admin.');
    }
}
