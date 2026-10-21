@extends('admin.layouts.app')

@section('title', 'Favorit & Bookmark')
@section('header_title', 'Analisis Buku Favorit & Bookmark')
@section('header_subtitle', 'Pantau tingkat ketertarikan dan minat pembaca terhadap koleksi publikasi statistik.')

@section('content')
<div class="space-y-6">

  <!-- Header Banner -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
    <div>
      <div class="flex items-center gap-2">
        <h2 class="text-lg font-black text-[#082b62]">Tingkat Ketertarikan Koleksi</h2>
        <span class="rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-bold text-amber-800 border border-amber-200">
          {{ number_format($totalFavorites) }} Total Bookmark
        </span>
      </div>
      <p class="text-xs text-slate-500 mt-0.5">
        {{ $totalFavoritedBooks }} Judul buku telah ditandai ke daftar favorit oleh pengguna aktif.
      </p>
    </div>

    <div class="inline-flex items-center gap-2 rounded-xl bg-blue-50 px-3.5 py-2 text-xs font-bold text-blue-900 border border-blue-100">
      <i data-lucide="trending-up" class="h-4 w-4 text-blue-600"></i>
      <span>Indikator Minat Riset Publik</span>
    </div>
  </div>

  <!-- Search & Filter Card -->
  <div class="rounded-2xl bg-white p-4 border border-slate-200/90 shadow-xs">
    <form action="{{ route('admin.favorites.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
      <div class="sm:col-span-8 relative flex items-center">
        <i data-lucide="search" class="absolute left-3.5 h-4 w-4 text-slate-400"></i>
        <input 
          type="search" 
          name="search" 
          value="{{ $search }}"
          placeholder="Cari judul buku favorit atau penulis..." 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-10 pr-4 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
      </div>

      <div class="sm:col-span-4 flex items-center gap-2">
        <select 
          name="category_id" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
          <option value="all">Semua Kategori</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ $selectedCategory == $cat->id ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>

        <button 
          type="submit" 
          class="rounded-xl bg-[#082b62] p-2.5 text-white hover:bg-blue-900 transition shrink-0"
        >
          <i data-lucide="filter" class="h-4 w-4"></i>
        </button>

        @if(!empty($search) || ($selectedCategory && $selectedCategory !== 'all'))
          <a 
            href="{{ route('admin.favorites.index') }}" 
            class="rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-slate-600 hover:bg-slate-100 transition shrink-0"
          >
            <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- 1. Books Ranked by Most Favorites -->
  <div class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
      <div>
        <h3 class="text-sm font-extrabold text-[#082b62]">Peringkat Buku Paling Banyak Difavoritkan</h3>
        <p class="text-xs text-slate-400 mt-0.5">Urutan buku berdasarkan jumlah bookmark dari pengguna terdaftar.</p>
      </div>
      <span class="text-xs font-bold text-slate-500">Tingkat Minat</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-700 border-b border-slate-200">
          <tr>
            <th class="py-3.5 px-4 w-12 text-center">Peringkat</th>
            <th class="py-3.5 px-4">Buku Publikasi</th>
            <th class="py-3.5 px-4">Kategori</th>
            <th class="py-3.5 px-4 text-center">Tahun Terbit</th>
            <th class="py-3.5 px-4 text-center">Jumlah Pengguna</th>
            <th class="py-3.5 px-4">Tingkat Ketertarikan</th>
            <th class="py-3.5 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 font-medium">
          @forelse($popularFavoriteBooks as $index => $book)
            @php
              $rank = $popularFavoriteBooks->firstItem() + $index;
              $interestPercentage = min(100, $book->favorites_count * 25);
            @endphp
            <tr class="hover:bg-blue-50/20 transition">
              <!-- Rank -->
              <td class="py-3.5 px-4 text-center">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-xl {{ $rank <= 3 ? 'bg-amber-400 text-slate-900 font-black shadow-xs' : 'bg-slate-100 text-slate-600 font-bold' }} text-xs">
                  {{ $rank }}
                </span>
              </td>

              <!-- Book Info -->
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-3 min-w-[240px]">
                  <img 
                    src="{{ $book->cover_url }}" 
                    alt="{{ $book->name }}" 
                    class="h-12 w-9 rounded-md object-cover border border-slate-200 shrink-0"
                    onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
                  >
                  <div class="min-w-0">
                    <a href="{{ route('admin.books.show', $book) }}" class="font-extrabold text-slate-900 hover:text-blue-700 transition block truncate leading-snug">
                      {{ $book->name }}
                    </a>
                    <span class="text-[11px] text-slate-400 block">{{ $book->author ?: 'BPS Jember' }}</span>
                  </div>
                </div>
              </td>

              <!-- Category -->
              <td class="py-3.5 px-4 whitespace-nowrap">
                <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-[11px] font-bold text-blue-700">
                  {{ $book->category?->name ?? 'Statistik' }}
                </span>
              </td>

              <!-- Year -->
              <td class="py-3.5 px-4 text-center font-bold text-slate-700 whitespace-nowrap">
                {{ $book->published_year }}
              </td>

              <!-- Favorites Count -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-black text-amber-800 border border-amber-200">
                  <i data-lucide="bookmark" class="h-3.5 w-3.5 text-amber-600 fill-amber-500"></i>
                  {{ $book->favorites_count }} Pengguna
                </span>
              </td>

              <!-- Interest Progress Bar -->
              <td class="py-3.5 px-4 min-w-[160px]">
                <div class="space-y-1">
                  <div class="flex items-center justify-between text-[10px] font-semibold text-slate-500">
                    <span>Popularitas</span>
                    <span class="text-amber-700 font-bold">{{ $book->favorites_count >= 3 ? 'Sangat Tinggi' : 'Tinggi' }}</span>
                  </div>
                  <div class="h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                    <div 
                      class="h-full rounded-full bg-gradient-to-r from-amber-400 to-yellow-500" 
                      style="width: {{ $interestPercentage }}%"
                    ></div>
                  </div>
                </div>
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <a 
                  href="{{ route('admin.books.show', $book) }}"
                  class="rounded-lg p-1.5 text-slate-500 hover:bg-blue-50 hover:text-blue-700 transition"
                  title="Lihat Detail Buku"
                >
                  <i data-lucide="eye" class="h-4 w-4"></i>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-10 text-center text-slate-400">
                Belum ada data buku yang difavoritkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($popularFavoriteBooks->hasPages())
      <div class="border-t border-slate-100 p-4">
        {{ $popularFavoriteBooks->links() }}
      </div>
    @endif
  </div>

  <!-- 2. Recent Bookmarking Activity by Users -->
  <div class="rounded-2xl bg-white border border-slate-200/90 shadow-xs p-6">
    <div class="pb-4 border-b border-slate-100 mb-4 flex items-center justify-between">
      <div>
        <h3 class="text-sm font-extrabold text-[#082b62]">Aktivitas Penambahan Bookmark Terkini</h3>
        <p class="text-xs text-slate-400">Pengguna yang baru-baru ini menyimpan buku ke koleksi favorit mereka.</p>
      </div>
      <span class="text-xs font-bold text-slate-500">{{ $recentFavorites->total() }} Catatan</span>
    </div>

    <div class="divide-y divide-slate-100 text-xs">
      @forelse($recentFavorites as $fav)
        <div class="py-3.5 flex items-center justify-between gap-4">
          <div class="flex items-center gap-3 min-w-0">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-50 text-amber-600">
              <i data-lucide="bookmark" class="h-4 w-4 fill-amber-500"></i>
            </span>
            <div class="min-w-0">
              <div class="flex items-center gap-2">
                <span class="font-extrabold text-slate-900">{{ $fav->user?->name ?? 'Pengguna' }}</span>
                <span class="text-slate-400">menambahkan ke favorit:</span>
              </div>
              <p class="font-bold text-blue-800 truncate mt-0.5">
                {{ $fav->book?->name ?? 'Publikasi' }}
              </p>
            </div>
          </div>

          <div class="flex items-center gap-3 shrink-0">
            <span class="text-[11px] text-slate-400 whitespace-nowrap">
              {{ $fav->created_at->diffForHumans() }}
            </span>

            <form action="{{ route('admin.favorites.destroy', $fav) }}" method="POST" onsubmit="return confirm('Hapus bookmark ini?');" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="p-1 rounded text-slate-400 hover:text-rose-600 transition" title="Hapus Bookmark">
                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
              </button>
            </form>
          </div>
        </div>
      @empty
        <div class="py-6 text-center text-xs text-slate-400">
          Belum ada aktivitas bookmark terbaru.
        </div>
      @endforelse
    </div>

    @if($recentFavorites->hasPages())
      <div class="border-t border-slate-100 pt-4 mt-2">
        {{ $recentFavorites->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
