<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk Admin - Perpustakaan Digital BPS Kabupaten Jember</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo-bps.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <script src="https://unpkg.com/lucide@latest"></script>
  @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden" style="background: radial-gradient(circle at 10% 20%, #082b62 0%, #051a3d 90%); font-family: 'Plus Jakarta Sans', sans-serif;">

  <!-- Background decorative elements -->
  <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-blue-600/20 blur-3xl pointer-events-none"></div>
  <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-yellow-500/15 blur-3xl pointer-events-none"></div>

  <div class="w-full max-w-md relative z-10">
    <!-- Back to Website Link -->
    <div class="mb-4 text-center">
      <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-200 hover:text-white transition">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        <span>Kembali ke Beranda Perpustakaan</span>
      </a>
    </div>

    <!-- Login Card -->
    <div class="rounded-3xl bg-white p-7 sm:p-9 shadow-2xl border border-white/20">
      
      <!-- Brand & Title -->
      <div class="text-center mb-6">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 border border-blue-100 p-2 shadow-xs mb-3">
          <img src="{{ asset('assets/images/logo-bps.svg') }}" alt="Logo BPS" class="h-full w-full object-contain">
        </div>
        <h1 class="text-xl font-extrabold text-[#082b62] tracking-tight">Portal Admin Perpustakaan</h1>
        <p class="text-xs text-slate-500 mt-1">Badan Pusat Statistik Kabupaten Jember</p>
      </div>

      <!-- Flash Messages -->
      @if(session('success'))
        <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 p-3 text-xs text-emerald-800 flex items-center gap-2">
          <i data-lucide="check-circle" class="h-4 w-4 shrink-0 text-emerald-600"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if(session('error'))
        <div class="mb-5 rounded-xl bg-rose-50 border border-rose-200 p-3 text-xs text-rose-800 flex items-center gap-2">
          <i data-lucide="alert-circle" class="h-4 w-4 shrink-0 text-rose-600"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif

      @if(session('warning'))
        <div class="mb-5 rounded-xl bg-amber-50 border border-amber-200 p-3 text-xs text-amber-800 flex items-center gap-2">
          <i data-lucide="alert-triangle" class="h-4 w-4 shrink-0 text-amber-600"></i>
          <span>{{ session('warning') }}</span>
        </div>
      @endif

      <!-- Login Form -->
      <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Email Field -->
        <div>
          <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
            Email Administrator
          </label>
          <div class="relative flex items-center">
            <span class="absolute left-3.5 text-slate-400">
              <i data-lucide="mail" class="h-4 w-4"></i>
            </span>
            <input 
              type="email" 
              name="email" 
              id="email" 
              value="{{ old('email', 'admin@bps.go.id') }}" 
              required 
              placeholder="admin@bps.go.id"
              class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-10 pr-4 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
            >
          </div>
          @error('email')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password Field -->
        <div>
          <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">
            Password
          </label>
          <div class="relative flex items-center">
            <span class="absolute left-3.5 text-slate-400">
              <i data-lucide="lock" class="h-4 w-4"></i>
            </span>
            <input 
              type="password" 
              name="password" 
              id="password" 
              value="password123"
              required 
              placeholder="••••••••"
              class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-10 pr-10 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition"
            >
            <button 
              type="button" 
              onclick="togglePasswordVisibility()" 
              class="absolute right-3.5 text-slate-400 hover:text-slate-600"
              aria-label="Tampilkan password"
            >
              <i id="eye-icon" data-lucide="eye" class="h-4 w-4"></i>
            </button>
          </div>
          @error('password')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between text-xs pt-1">
          <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
            <span>Ingat saya</span>
          </label>
          <span class="text-[11px] text-slate-400">Akses Khusus Pengelola</span>
        </div>

        <!-- Submit Button -->
        <button 
          type="submit" 
          class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-[#082b62] py-3 text-xs font-extrabold text-white shadow-md hover:bg-[#0d3b84] transition active:scale-98"
        >
          <i data-lucide="log-in" class="h-4 w-4"></i>
          <span>Masuk ke Dashboard</span>
        </button>
      </form>

      <!-- Quick Demo Login Button -->
      <div class="mt-4 pt-4 border-t border-slate-100">
        <a 
          href="{{ route('admin.quick_login') }}" 
          class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500/10 border border-amber-300/60 py-2.5 text-xs font-bold text-amber-900 hover:bg-amber-500/20 transition"
        >
          <i data-lucide="zap" class="h-3.5 w-3.5 text-amber-600"></i>
          <span>Masuk Cepat Demo Admin (1 Klik)</span>
        </a>
        <p class="mt-2 text-center text-[11px] text-slate-400">
          Akun Demo: <strong>admin@bps.go.id</strong> / <strong>password123</strong>
        </p>
      </div>

    </div>

    <!-- Security Footer Note -->
    <p class="mt-6 text-center text-[11px] text-blue-200/80">
      &copy; {{ date('Y') }} Badan Pusat Statistik Kabupaten Jember. Seluruh Hak Dilindungi.
    </p>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      if (typeof lucide !== 'undefined') {
        lucide.createIcons();
      }
    });

    function togglePasswordVisibility() {
      const pwd = document.getElementById('password');
      const icon = document.getElementById('eye-icon');
      if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.setAttribute('data-lucide', 'eye-off');
      } else {
        pwd.type = 'password';
        icon.setAttribute('data-lucide', 'eye');
      }
      if (typeof lucide !== 'undefined') lucide.createIcons();
    }
  </script>
</body>
</html>
