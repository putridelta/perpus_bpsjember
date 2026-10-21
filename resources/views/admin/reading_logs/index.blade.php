@extends('admin.layouts.app')

@section('title', 'Riwayat Baca')
@section('header_title', 'Riwayat Aktivitas Membaca')
@section('header_subtitle', 'Pantau log aktivitas membaca seluruh pengguna dan tamu pada platform buku digital.')

@section('content')
<div class="space-y-6">

  <!-- Header Banner & Action Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
    <div>
      <div class="flex items-center gap-2">
        <h2 class="text-lg font-black text-[#082b62]">Log Pembacaan Terdata</h2>
        <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-700">
          {{ number_format($totalLogsCount) }} Total Sesi
        </span>
      </div>
      <p class="text-xs text-slate-500 mt-0.5">
        {{ $todayLogsCount }} Sesi Hari Ini &bull; {{ $uniqueReadersCount }} Pembaca Unik Teridentifikasi
      </p>
    </div>

    <!-- Clear Old Logs Button -->
    <form action="{{ route('admin.reading_logs.clear_old') }}" method="POST" onsubmit="return confirm('Bersihkan riwayat baca yang berumur lebih dari 60 hari?');">
      @csrf
      <button 
        type="submit" 
        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition"
      >
        <i data-lucide="brush" class="h-3.5 w-3.5 text-slate-400"></i>
        <span>Bersihkan Log Lama (>60 Hari)</span>
      </button>
    </form>
  </div>

  <!-- Search & Filter Card -->
  <div class="rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
    <form action="{{ route('admin.reading_logs.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
      
      <!-- Search Input -->
      <div class="lg:col-span-4 relative flex items-center">
        <i data-lucide="search" class="absolute left-3.5 h-4 w-4 text-slate-400"></i>
        <input 
          type="search" 
          name="search" 
          value="{{ $search }}"
          placeholder="Cari pengguna, buku, aktivitas, IP..." 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-10 pr-4 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
      </div>

      <!-- Filter Book -->
      <div class="lg:col-span-3">
        <select 
          name="book_id" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
          <option value="all">Semua Buku</option>
          @foreach($books as $b)
            <option value="{{ $b->id }}" {{ $selectedBook == $b->id ? 'selected' : '' }}>
              {{ $b->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Filter User -->
      <div class="lg:col-span-2">
        <select 
          name="user_id" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
          <option value="all">Semua Pengguna</option>
          @foreach($users as $u)
            <option value="{{ $u->id }}" {{ $selectedUser == $u->id ? 'selected' : '' }}>
              {{ $u->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Filter Period -->
      <div class="lg:col-span-3 flex items-center gap-2">
        <select 
          name="period" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
          <option value="all">Semua Periode</option>
          <option value="today" {{ $selectedPeriod === 'today' ? 'selected' : '' }}>Hari Ini</option>
          <option value="week" {{ $selectedPeriod === 'week' ? 'selected' : '' }}>7 Hari Terakhir</option>
          <option value="month" {{ $selectedPeriod === 'month' ? 'selected' : '' }}>30 Hari Terakhir</option>
        </select>

        <button 
          type="submit" 
          class="rounded-xl bg-[#082b62] p-2.5 text-white hover:bg-blue-900 transition shrink-0" 
          title="Terapkan Filter"
        >
          <i data-lucide="filter" class="h-4 w-4"></i>
        </button>

        @if(!empty($search) || ($selectedBook && $selectedBook !== 'all') || ($selectedUser && $selectedUser !== 'all') || ($selectedPeriod && $selectedPeriod !== 'all'))
          <a 
            href="{{ route('admin.reading_logs.index') }}" 
            class="rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-slate-600 hover:bg-slate-100 transition shrink-0"
            title="Reset Filter"
          >
            <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
          </a>
        @endif
      </div>

    </form>
  </div>

  <!-- Reading Logs Table -->
  <div class="overflow-hidden rounded-2xl bg-white border border-slate-200/90 shadow-xs">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-700 border-b border-slate-200">
          <tr>
            <th class="py-3.5 px-4 w-12 text-center">No</th>
            <th class="py-3.5 px-4">Nama Pengguna</th>
            <th class="py-3.5 px-4">Buku Yang Dibaca</th>
            <th class="py-3.5 px-4">Aktivitas Terakhir</th>
            <th class="py-3.5 px-4 text-center">Durasi</th>
            <th class="py-3.5 px-4">Waktu Baca</th>
            <th class="py-3.5 px-4 text-center">IP Address</th>
            <th class="py-3.5 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 font-medium">
          @forelse($logs as $index => $log)
            <tr class="hover:bg-blue-50/20 transition">
              <!-- Number -->
              <td class="py-3.5 px-4 text-center text-slate-400 font-semibold">
                {{ $logs->firstItem() + $index }}
              </td>

              <!-- User -->
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-2.5">
                  <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-700 font-bold text-xs">
                    {{ substr($log->user ? $log->user->name : ($log->user_name ?: 'P'), 0, 1) }}
                  </span>
                  <div>
                    @if($log->user)
                      <a href="{{ route('admin.users.show', $log->user) }}" class="font-extrabold text-slate-900 hover:text-blue-700 transition block">
                        {{ $log->user->name }}
                      </a>
                      <span class="text-[10px] text-slate-400 block">{{ $log->user->email }}</span>
                    @else
                      <span class="font-bold text-slate-800 block">{{ $log->user_name ?: 'Pengunjung Publik' }}</span>
                      <span class="text-[10px] text-slate-400 italic">Tamu Web</span>
                    @endif
                  </div>
                </div>
              </td>

              <!-- Book -->
              <td class="py-3.5 px-4 max-w-xs">
                @if($log->book)
                  <div class="flex items-center gap-2.5">
                    <img 
                      src="{{ $log->book->cover_url }}" 
                      alt="{{ $log->book->name }}" 
                      class="h-10 w-7 rounded-sm object-cover border border-slate-200 shrink-0"
                      onerror="this.src='{{ asset('assets/images/cover-buku1.jpg') }}'"
                    >
                    <div class="min-w-0">
                      <a href="{{ route('admin.books.show', $log->book) }}" class="font-bold text-slate-900 hover:text-blue-700 transition block truncate leading-tight">
                        {{ $log->book->name }}
                      </a>
                      <span class="text-[10px] text-blue-700 font-semibold">
                        {{ $log->book->category?->name ?? 'Statistik' }} &bull; {{ $log->book->published_year }}
                      </span>
                    </div>
                  </div>
                @else
                  <span class="text-slate-400 italic">Buku telah dihapus</span>
                @endif
              </td>

              <!-- Activity Note -->
              <td class="py-3.5 px-4">
                <span class="inline-flex items-center gap-1 text-slate-800 font-semibold">
                  <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                  {{ $log->activity_note }}
                </span>
              </td>

              <!-- Duration -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <span class="rounded-md bg-slate-100 px-2 py-0.5 font-bold text-slate-700 text-[11px]">
                  {{ $log->read_duration_minutes }} mnt
                </span>
              </td>

              <!-- Date / Time -->
              <td class="py-3.5 px-4 whitespace-nowrap">
                <span class="text-slate-800 font-semibold block">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</span>
                <span class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</span>
              </td>

              <!-- IP Address -->
              <td class="py-3.5 px-4 text-center text-slate-500 font-mono text-[11px] whitespace-nowrap">
                {{ $log->ip_address ?: '-' }}
              </td>

              <!-- Action -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <form action="{{ route('admin.reading_logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Hapus baris log ini?');" class="inline">
                  @csrf
                  @method('DELETE')
                  <button 
                    type="submit" 
                    class="rounded-lg p-1.5 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition"
                    title="Hapus Log"
                  >
                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="py-12 text-center text-slate-400">
                <div class="flex flex-col items-center justify-center">
                  <i data-lucide="history" class="h-10 w-10 text-slate-300 mb-2"></i>
                  <p class="font-bold text-slate-600">Tidak ada riwayat baca ditemukan</p>
                  <p class="text-xs text-slate-400 mt-0.5">Coba sesuaikan filter pencarian Anda.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($logs->hasPages())
      <div class="border-t border-slate-100 p-4">
        {{ $logs->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
