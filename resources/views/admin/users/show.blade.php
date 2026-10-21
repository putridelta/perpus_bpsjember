@extends('admin.layouts.app')

@section('title', 'Detail Pengguna - ' . $user->name)
@section('header_title', 'Profil & Aktivitas Pengguna')
@section('header_subtitle', 'Informasi akun, histori pembacaan dokumen, dan koleksi favorit pengguna.')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
  
  <!-- Back Link & Action Bar -->
  <div class="flex items-center justify-between">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 hover:underline">
      <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
      <span>Kembali ke Daftar Pengguna</span>
    </a>

    <div class="flex items-center gap-2">
      <a 
        href="{{ route('admin.users.edit', $user) }}" 
        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-xs"
      >
        <i data-lucide="edit-3" class="h-3.5 w-3.5 text-amber-600"></i>
        <span>Edit Pengguna</span>
      </a>
    </div>
  </div>

  <!-- User Profile Card -->
  <div class="rounded-3xl bg-white p-6 sm:p-8 border border-slate-200/90 shadow-xs">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 pb-6 border-b border-slate-100">
      
      <div class="flex items-center gap-4">
        <img 
          src="{{ $user->avatar_url }}" 
          alt="{{ $user->name }}" 
          class="h-16 w-16 rounded-full object-cover border-2 border-blue-600 shadow-sm"
        >
        <div>
          <div class="flex items-center gap-2">
            <h2 class="text-lg sm:text-xl font-black text-[#082b62]">{{ $user->name }}</h2>
            @if($user->role === 'admin')
              <span class="rounded-full bg-blue-100 text-blue-900 text-[10px] font-extrabold px-2.5 py-0.5 border border-blue-200">
                ADMIN
              </span>
            @else
              <span class="rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold px-2.5 py-0.5">
                ANGGOTA
              </span>
            @endif
          </div>

          <p class="text-xs text-slate-500 mt-0.5">{{ $user->email }} &bull; {{ $user->phone ?: 'Tidak ada nomor telepon' }}</p>
          <p class="text-[11px] text-slate-400 mt-1">
            Bergabung sejak: {{ $user->created_at->translatedFormat('d F Y') }} ({{ $user->created_at->diffForHumans() }})
          </p>
        </div>
      </div>

      <div>
        @if($user->status === 'active')
          <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
            Akun Aktif
          </span>
        @else
          <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700 border border-rose-200">
            <span class="h-2 w-2 rounded-full bg-rose-500"></span>
            Akun Nonaktif
          </span>
        @endif
      </div>

    </div>

    <!-- User Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6">
      <div class="rounded-2xl bg-blue-50/60 border border-blue-100 p-4">
        <span class="text-xs font-bold text-blue-900 uppercase tracking-wider">Buku Pernah Dibaca</span>
        <h4 class="text-2xl font-black text-[#082b62] mt-1">{{ $uniqueBooksReadCount }} Judul</h4>
        <p class="text-[11px] text-blue-700 mt-0.5">Koleksi unik yang pernah dibuka</p>
      </div>

      <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">
        <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Total Sesi Membaca</span>
        <h4 class="text-2xl font-black text-slate-800 mt-1">{{ $user->readingLogs->count() }} Sesi</h4>
        <p class="text-[11px] text-slate-500 mt-0.5">Frekuensi interaksi baca</p>
      </div>

      <div class="rounded-2xl bg-amber-50/60 border border-amber-200 p-4">
        <span class="text-xs font-bold text-amber-900 uppercase tracking-wider">Koleksi Favorit</span>
        <h4 class="text-2xl font-black text-amber-800 mt-1">{{ $favorites->count() }} Buku</h4>
        <p class="text-[11px] text-amber-700 mt-0.5">Tersimpan di bookmark</p>
      </div>
    </div>
  </div>

  <!-- Reading History List -->
  <div class="rounded-2xl bg-white p-6 border border-slate-200/90 shadow-xs">
    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
      <div>
        <h3 class="text-sm font-extrabold text-[#082b62]">Histori Aktivitas Membaca Pengguna</h3>
        <p class="text-xs text-slate-400">Daftar publikasi statistik yang dibaca oleh pengguna ini.</p>
      </div>
      <span class="text-xs font-bold text-blue-700">
        {{ $user->readingLogs->count() }} Riwayat
      </span>
    </div>

    <div class="divide-y divide-slate-100 text-xs">
      @forelse($recentReads as $log)
        <div class="py-3.5 flex items-center justify-between gap-4">
          <div class="flex items-center gap-3 min-w-0">
            @if($log->book)
              <img 
                src="{{ $log->book->cover_url }}" 
                alt="{{ $log->book->name }}" 
                class="h-11 w-8 rounded-md object-cover border border-slate-200 shrink-0"
                onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
              >
              <div class="min-w-0">
                <a href="{{ route('admin.books.show', $log->book) }}" class="font-bold text-slate-900 hover:text-blue-700 transition block truncate">
                  {{ $log->book->name }}
                </a>
                <div class="flex items-center gap-2 mt-0.5 text-[11px] text-slate-400">
                  <span class="text-blue-700 font-semibold">{{ $log->book->category?->name ?? 'Statistik' }}</span>
                  <span>&bull;</span>
                  <span>{{ $log->activity_note }}</span>
                  <span>&bull;</span>
                  <span>{{ $log->read_duration_minutes }} menit</span>
                </div>
              </div>
            @else
              <span class="text-slate-400 italic">Buku telah dihapus dari sistem</span>
            @endif
          </div>

          <div class="text-right shrink-0">
            <span class="text-slate-500 font-medium block">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</span>
            <span class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</span>
          </div>
        </div>
      @empty
        <div class="py-8 text-center text-xs text-slate-400">
          Pengguna ini belum memiliki riwayat membaca publikasi.
        </div>
      @endforelse
    </div>
  </div>

  <!-- Bookmarks / Favorites -->
  @if($favorites->isNotEmpty())
    <div class="rounded-2xl bg-white p-6 border border-slate-200/90 shadow-xs">
      <h3 class="text-sm font-extrabold text-[#082b62] mb-4">Buku Ditandai Sebagai Favorit</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($favorites as $fav)
          @if($fav->book)
            <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50/50">
              <img 
                src="{{ $fav->book->cover_url }}" 
                alt="{{ $fav->book->name }}" 
                class="h-12 w-9 rounded-md object-cover border border-slate-200 shrink-0"
              >
              <div class="min-w-0">
                <a href="{{ route('admin.books.show', $fav->book) }}" class="text-xs font-bold text-slate-900 hover:text-blue-700 transition truncate block">
                  {{ $fav->book->name }}
                </a>
                <span class="text-[10px] text-blue-700 font-semibold block mt-0.5">
                  {{ $fav->book->category?->name }}
                </span>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>
  @endif

</div>
@endsection
