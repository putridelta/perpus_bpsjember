<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Dashboard Administrator Perpustakaan Digital BPS Kabupaten Jember">
  <title>@yield('title', 'Admin Dashboard') - Perpustakaan Digital BPS Jember</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo-bps.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  @vite(['resources/css/app.css'])

  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fbff;
      color: #0f172a;
    }
    .admin-navy {
      background-color: #082b62;
    }
    .admin-navy-dark {
      background-color: #051d45;
    }
    .admin-blue {
      color: #1565c0;
    }
    .admin-border {
      border-color: #e2e8f0;
    }
    /* Custom scrollbars */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }
  </style>
  @stack('styles')
</head>

<body class="min-h-screen flex flex-col antialiased">
  <div class="flex h-screen overflow-hidden bg-[#f8fbff]">

    <!-- Sidebar Backdrop (Mobile) -->
    <div 
      id="sidebar-backdrop" 
      class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-xs transition-opacity lg:hidden hidden"
      onclick="toggleSidebar()"
    ></div>

    <!-- Main Sidebar -->
    <aside 
      id="admin-sidebar" 
      class="fixed inset-y-0 left-0 z-50 w-72 bg-[#082b62] text-white flex flex-col justify-between transition-transform duration-300 ease-in-out -translate-x-full lg:static lg:translate-x-0 shadow-2xl lg:shadow-none"
    >
      <!-- Brand & Header -->
      <div>
        <div class="flex h-[72px] items-center justify-between px-6 border-b border-white/10 bg-[#06204a]">
          <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10 p-1.5 shadow-inner">
              <img src="{{ asset('assets/images/logo-bps.svg') }}" alt="Logo BPS" class="h-full w-full object-contain">
            </span>
            <div class="flex flex-col">
              <span class="text-xs font-black tracking-wider uppercase text-white">PERPUSTAKAAN DIGITAL</span>
              <span class="text-[10px] font-semibold text-blue-200">BPS KABUPATEN JEMBER</span>
            </div>
          </a>
          <!-- Close button on mobile -->
          <button 
            type="button" 
            onclick="toggleSidebar()" 
            class="rounded-lg p-1 text-blue-200 hover:bg-white/10 lg:hidden"
            aria-label="Tutup Menu"
          >
            <i data-lucide="x" class="h-5 w-5"></i>
          </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-4 px-4 space-y-1 overflow-y-auto max-h-[calc(100vh-170px)]">
          <div class="px-3 py-2 text-[10px] font-extrabold uppercase tracking-widest text-blue-300/80">
            Menu Utama
          </div>

          <!-- 1. Dashboard -->
          <a 
            href="{{ route('admin.dashboard') }}" 
            class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all {{ request()->routeIs('admin.dashboard*') ? 'bg-[#1565c0] text-white shadow-md' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
          >
            <i data-lucide="layout-dashboard" class="h-4 w-4 shrink-0 {{ request()->routeIs('admin.dashboard*') ? 'text-yellow-300' : 'text-blue-200' }}"></i>
            <span>Dashboard</span>
          </a>

          <!-- 2. Manajemen Buku -->
          <a 
            href="{{ route('admin.books.index') }}" 
            class="flex items-center justify-between rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all {{ request()->routeIs('admin.books*') ? 'bg-[#1565c0] text-white shadow-md' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
          >
            <div class="flex items-center gap-3">
              <i data-lucide="book-open" class="h-4 w-4 shrink-0 {{ request()->routeIs('admin.books*') ? 'text-yellow-300' : 'text-blue-200' }}"></i>
              <span>Manajemen Buku</span>
            </div>
            <span class="rounded-full bg-white/15 px-2 py-0.5 text-[10px] font-bold text-white">
              {{ \App\Models\Book::count() }}
            </span>
          </a>

          <!-- 3. Manajemen User -->
          <a 
            href="{{ route('admin.users.index') }}" 
            class="flex items-center justify-between rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all {{ request()->routeIs('admin.users*') ? 'bg-[#1565c0] text-white shadow-md' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
          >
            <div class="flex items-center gap-3">
              <i data-lucide="users" class="h-4 w-4 shrink-0 {{ request()->routeIs('admin.users*') ? 'text-yellow-300' : 'text-blue-200' }}"></i>
              <span>Manajemen User</span>
            </div>
            <span class="rounded-full bg-white/15 px-2 py-0.5 text-[10px] font-bold text-white">
              {{ \App\Models\User::count() }}
            </span>
          </a>

          <!-- 4. Kategori Buku -->
          <a 
            href="{{ route('admin.categories.index') }}" 
            class="flex items-center justify-between rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all {{ request()->routeIs('admin.categories*') ? 'bg-[#1565c0] text-white shadow-md' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
          >
            <div class="flex items-center gap-3">
              <i data-lucide="tags" class="h-4 w-4 shrink-0 {{ request()->routeIs('admin.categories*') ? 'text-yellow-300' : 'text-blue-200' }}"></i>
              <span>Kategori Buku</span>
            </div>
            <span class="rounded-full bg-white/15 px-2 py-0.5 text-[10px] font-bold text-white">
              {{ \App\Models\Category::count() }}
            </span>
          </a>

          <div class="pt-3 px-3 py-2 text-[10px] font-extrabold uppercase tracking-widest text-blue-300/80">
            Aktivitas & Data
          </div>

          <!-- 5. Riwayat Baca -->
          <a 
            href="{{ route('admin.reading_logs.index') }}" 
            class="flex items-center justify-between rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all {{ request()->routeIs('admin.reading_logs*') ? 'bg-[#1565c0] text-white shadow-md' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
          >
            <div class="flex items-center gap-3">
              <i data-lucide="history" class="h-4 w-4 shrink-0 {{ request()->routeIs('admin.reading_logs*') ? 'text-yellow-300' : 'text-blue-200' }}"></i>
              <span>Riwayat Baca</span>
            </div>
            <span class="rounded-full bg-yellow-400/20 text-yellow-300 px-2 py-0.5 text-[10px] font-bold">
              {{ \App\Models\ReadingLog::count() }}
            </span>
          </a>

          <!-- 6. Favorit / Bookmark -->
          <a 
            href="{{ route('admin.favorites.index') }}" 
            class="flex items-center justify-between rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all {{ request()->routeIs('admin.favorites*') ? 'bg-[#1565c0] text-white shadow-md' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
          >
            <div class="flex items-center gap-3">
              <i data-lucide="bookmark-check" class="h-4 w-4 shrink-0 {{ request()->routeIs('admin.favorites*') ? 'text-yellow-300' : 'text-blue-200' }}"></i>
              <span>Favorit / Bookmark</span>
            </div>
            <span class="rounded-full bg-white/15 px-2 py-0.5 text-[10px] font-bold text-white">
              {{ \App\Models\Favorite::count() }}
            </span>
          </a>

          <!-- 7. Laporan & Statistik -->
          <a 
            href="{{ route('admin.reports.index') }}" 
            class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all {{ request()->routeIs('admin.reports*') ? 'bg-[#1565c0] text-white shadow-md' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
          >
            <i data-lucide="bar-chart-3" class="h-4 w-4 shrink-0 {{ request()->routeIs('admin.reports*') ? 'text-yellow-300' : 'text-blue-200' }}"></i>
            <span>Laporan & Statistik</span>
          </a>

          <div class="pt-3 px-3 py-2 text-[10px] font-extrabold uppercase tracking-widest text-blue-300/80">
            Sistem
          </div>

          <!-- 8. Pengaturan -->
          <a 
            href="{{ route('admin.settings.index') }}" 
            class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all {{ request()->routeIs('admin.settings*') ? 'bg-[#1565c0] text-white shadow-md' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}"
          >
            <i data-lucide="settings" class="h-4 w-4 shrink-0 {{ request()->routeIs('admin.settings*') ? 'text-yellow-300' : 'text-blue-200' }}"></i>
            <span>Pengaturan</span>
          </a>
        </nav>
      </div>

      <!-- Sidebar Footer User Profile -->
      <div class="p-4 border-t border-white/10 bg-[#061d45]">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2.5 min-w-0">
            <img 
              src="{{ Auth::user() ? Auth::user()->avatar_url : 'https://ui-avatars.com/api/?name=Admin&background=1565c0&color=fff' }}" 
              alt="Avatar Admin" 
              class="h-9 w-9 rounded-full object-cover border border-white/20 shrink-0"
            >
            <div class="min-w-0">
              <p class="text-xs font-bold text-white truncate">{{ Auth::user() ? Auth::user()->name : 'Admin Perpustakaan' }}</p>
              <span class="inline-flex items-center gap-1 text-[10px] text-yellow-300 font-semibold">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                Administrator
              </span>
            </div>
          </div>

          <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button 
              type="submit" 
              class="rounded-lg p-2 text-blue-300 hover:bg-white/10 hover:text-white transition"
              title="Keluar / Logout"
            >
              <i data-lucide="log-out" class="h-4 w-4"></i>
            </button>
          </form>
        </div>
      </div>
    </aside>

    <!-- Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
      
      <!-- Top Navigation Bar -->
      <header class="sticky top-0 z-30 flex h-[72px] items-center justify-between border-b border-slate-200 bg-white/95 px-4 sm:px-8 backdrop-blur-md">
        <!-- Left: Mobile Toggle & Page Title -->
        <div class="flex items-center gap-3">
          <button 
            type="button" 
            onclick="toggleSidebar()" 
            class="rounded-xl p-2 text-slate-600 hover:bg-slate-100 lg:hidden"
            aria-label="Buka Menu"
          >
            <i data-lucide="menu" class="h-6 w-6"></i>
          </button>

          <div>
            <h1 class="text-base sm:text-lg font-black text-[#082b62] leading-tight">
              @yield('header_title', 'Dashboard Administrator')
            </h1>
            <p class="text-[11px] text-slate-500 hidden sm:block">
              @yield('header_subtitle', 'Kelola koleksi buku statistik, pengguna, dan aktivitas membaca digital.')
            </p>
          </div>
        </div>

        <!-- Right: Actions & User Info -->
        <div class="flex items-center gap-3">
          <!-- View Public Website -->
          <a 
            href="{{ route('home') }}" 
            target="_blank"
            class="hidden sm:inline-flex items-center gap-1.5 rounded-xl border border-blue-200 bg-blue-50/70 px-3.5 py-2 text-xs font-bold text-[#082b62] hover:bg-blue-100 hover:text-blue-900 transition"
            title="Buka Website Pengunjung"
          >
            <i data-lucide="external-link" class="h-3.5 w-3.5 text-blue-700"></i>
            <span>Lihat Website</span>
          </a>

          <!-- Quick Read Catalog -->
          <a 
            href="{{ route('katalog.index') }}" 
            target="_blank"
            class="hidden md:inline-flex items-center gap-1.5 rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition"
            title="Buka Katalog Buku"
          >
            <i data-lucide="book-marked" class="h-3.5 w-3.5 text-slate-500"></i>
            <span>Katalog</span>
          </a>

          <!-- Admin Profile Badge -->
          <div class="flex items-center gap-2 pl-2 border-l border-slate-200">
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 group">
              <img 
                src="{{ Auth::user() ? Auth::user()->avatar_url : 'https://ui-avatars.com/api/?name=Admin&background=1565c0&color=fff' }}" 
                alt="Avatar" 
                class="h-8 w-8 rounded-full object-cover border border-slate-200 group-hover:ring-2 group-hover:ring-blue-400 transition"
              >
              <div class="hidden xl:flex flex-col text-left">
                <span class="text-xs font-bold text-slate-800 leading-tight group-hover:text-blue-700">{{ Auth::user() ? Auth::user()->name : 'Admin' }}</span>
                <span class="text-[10px] text-slate-400">Pengelola</span>
              </div>
            </a>
          </div>
        </div>
      </header>

      <!-- Main Body Content -->
      <main class="flex-1 p-4 sm:p-6 lg:p-8">
        
        <!-- Flash Message Alerts -->
        @if(session('success'))
          <div class="mb-6 flex items-center justify-between gap-3 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-900 shadow-xs animate-fade-in">
            <div class="flex items-center gap-3">
              <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-xs">
                <i data-lucide="check-circle" class="h-5 w-5"></i>
              </span>
              <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="rounded-lg p-1 text-emerald-700 hover:bg-emerald-100 transition">
              <i data-lucide="x" class="h-4 w-4"></i>
            </button>
          </div>
        @endif

        @if(session('error'))
          <div class="mb-6 flex items-center justify-between gap-3 rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-900 shadow-xs">
            <div class="flex items-center gap-3">
              <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-rose-500 text-white shadow-xs">
                <i data-lucide="alert-octagon" class="h-5 w-5"></i>
              </span>
              <p class="text-xs sm:text-sm font-semibold">{{ session('error') }}</p>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="rounded-lg p-1 text-rose-700 hover:bg-rose-100 transition">
              <i data-lucide="x" class="h-4 w-4"></i>
            </button>
          </div>
        @endif

        @if(session('warning'))
          <div class="mb-6 flex items-center justify-between gap-3 rounded-2xl bg-amber-50 border border-amber-200 p-4 text-amber-900 shadow-xs">
            <div class="flex items-center gap-3">
              <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-xs">
                <i data-lucide="alert-triangle" class="h-5 w-5"></i>
              </span>
              <p class="text-xs sm:text-sm font-semibold">{{ session('warning') }}</p>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="rounded-lg p-1 text-amber-700 hover:bg-amber-100 transition">
              <i data-lucide="x" class="h-4 w-4"></i>
            </button>
          </div>
        @endif

        @if($errors->any())
          <div class="mb-6 rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-900 shadow-xs">
            <div class="flex items-center gap-2 mb-2 font-bold text-xs sm:text-sm">
              <i data-lucide="alert-circle" class="h-4 w-4 text-rose-600"></i>
              <span>Terdapat kesalahan pada isian form:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @yield('content')
      </main>

      <!-- Admin Footer -->
      <footer class="border-t border-slate-200 bg-white py-4 px-6 text-center sm:text-left">
        <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
          <span>&copy; {{ date('Y') }} <strong>Badan Pusat Statistik Kabupaten Jember</strong>. Seluruh Hak Cipta Dilindungi.</span>
          <span class="text-[11px] text-slate-400">Panel Administrator Perpustakaan Digital Resmi &bull; v2.0</span>
        </div>
      </footer>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('admin-sidebar');
      const backdrop = document.getElementById('sidebar-backdrop');
      if (!sidebar) return;

      if (sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
      } else {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      if (typeof lucide !== 'undefined') {
        lucide.createIcons();
      }
    });
  </script>
  @stack('scripts')
</body>
</html>
