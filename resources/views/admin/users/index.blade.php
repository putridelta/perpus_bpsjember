@extends('admin.layouts.app')

@section('title', 'Manajemen User')
@section('header_title', 'Manajemen Pengguna & Anggota')
@section('header_subtitle', 'Kelola akun administrator, staf perpustakaan, dan anggota pembaca digital.')

@section('content')
<div class="space-y-6">

  <!-- Header Banner & Action Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
    <div>
      <div class="flex items-center gap-2">
        <h2 class="text-lg font-black text-[#082b62]">Daftar Pengguna Sistem</h2>
        <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-700">
          {{ number_format($totalUsers) }} Pengguna
        </span>
      </div>
      <p class="text-xs text-slate-500 mt-0.5">
        {{ $adminCount }} Administrator &bull; {{ $memberCount }} Anggota Pembaca &bull; {{ $activeCount }} Akun Aktif
      </p>
    </div>

    <a 
      href="{{ route('admin.users.create') }}" 
      class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#082b62] px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-[#0e3c82] transition transform hover:-translate-y-0.5"
    >
      <i data-lucide="user-plus" class="h-4 w-4 text-yellow-400"></i>
      <span>Tambah Pengguna Baru</span>
    </a>
  </div>

  <!-- Search & Filter Card -->
  <div class="rounded-2xl bg-white p-5 border border-slate-200/90 shadow-xs">
    <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
      
      <!-- Search Input -->
      <div class="lg:col-span-6 relative flex items-center">
        <i data-lucide="search" class="absolute left-3.5 h-4 w-4 text-slate-400"></i>
        <input 
          type="search" 
          name="search" 
          value="{{ $search }}"
          placeholder="Cari nama pengguna, email, atau nomor telepon..." 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-10 pr-4 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
      </div>

      <!-- Role Filter -->
      <div class="lg:col-span-3">
        <select 
          name="role" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
          <option value="all">Semua Peran (Role)</option>
          <option value="admin" {{ $selectedRole === 'admin' ? 'selected' : '' }}>Administrator</option>
          <option value="user" {{ $selectedRole === 'user' ? 'selected' : '' }}>Anggota / Pengguna</option>
        </select>
      </div>

      <!-- Status Filter & Actions -->
      <div class="lg:col-span-3 flex items-center gap-2">
        <select 
          name="status" 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
          <option value="all">Semua Status</option>
          <option value="active" {{ $selectedStatus === 'active' ? 'selected' : '' }}>Aktif</option>
          <option value="inactive" {{ $selectedStatus === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
        </select>

        <button 
          type="submit" 
          class="rounded-xl bg-[#082b62] p-2.5 text-white hover:bg-blue-900 transition shrink-0" 
          title="Terapkan Filter"
        >
          <i data-lucide="filter" class="h-4 w-4"></i>
        </button>

        @if(!empty($search) || ($selectedRole && $selectedRole !== 'all') || ($selectedStatus && $selectedStatus !== 'all'))
          <a 
            href="{{ route('admin.users.index') }}" 
            class="rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-slate-600 hover:bg-slate-100 transition shrink-0"
            title="Reset Filter"
          >
            <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
          </a>
        @endif
      </div>

    </form>
  </div>

  <!-- Users Table -->
  <div class="overflow-hidden rounded-2xl bg-white border border-slate-200/90 shadow-xs">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-700 border-b border-slate-200">
          <tr>
            <th class="py-3.5 px-4 w-12 text-center">No</th>
            <th class="py-3.5 px-4">Pengguna</th>
            <th class="py-3.5 px-4">Kontak / Telepon</th>
            <th class="py-3.5 px-4 text-center">Peran (Role)</th>
            <th class="py-3.5 px-4 text-center">Status Akun</th>
            <th class="py-3.5 px-4 text-center">Buku Dibaca</th>
            <th class="py-3.5 px-4 text-center">Terdaftar</th>
            <th class="py-3.5 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 font-medium">
          @forelse($users as $index => $u)
            <tr class="hover:bg-blue-50/20 transition">
              <!-- Number -->
              <td class="py-3.5 px-4 text-center text-slate-400 font-semibold">
                {{ $users->firstItem() + $index }}
              </td>

              <!-- User & Avatar -->
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-3 min-w-[200px]">
                  <img 
                    src="{{ $u->avatar_url }}" 
                    alt="{{ $u->name }}" 
                    class="h-9 w-9 rounded-full object-cover border border-slate-200 shrink-0"
                  >
                  <div class="min-w-0">
                    <a href="{{ route('admin.users.show', $u) }}" class="font-extrabold text-slate-900 hover:text-blue-700 transition block truncate">
                      {{ $u->name }}
                    </a>
                    <span class="text-[11px] text-slate-400 block truncate">
                      {{ $u->email }}
                    </span>
                  </div>
                </div>
              </td>

              <!-- Phone -->
              <td class="py-3.5 px-4 whitespace-nowrap">
                <span class="text-slate-700 font-semibold">{{ $u->phone ?: '-' }}</span>
              </td>

              <!-- Role -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                @if($u->role === 'admin')
                  <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-0.5 text-[11px] font-extrabold text-blue-900 border border-blue-200">
                    <i data-lucide="shield" class="h-3 w-3 text-blue-700"></i>
                    Admin
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-semibold text-slate-700 border border-slate-200">
                    <i data-lucide="user" class="h-3 w-3 text-slate-500"></i>
                    Anggota
                  </span>
                @endif
              </td>

              <!-- Status -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                @if($u->status === 'active')
                  <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700 border border-emerald-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Aktif
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-0.5 text-[11px] font-bold text-rose-700 border border-rose-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                    Nonaktif
                  </span>
                @endif
              </td>

              <!-- Books Read Count -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <span class="inline-flex items-center gap-1 font-bold text-[#082b62] bg-blue-50/80 px-2.5 py-0.5 rounded-lg border border-blue-100">
                  <i data-lucide="book-open" class="h-3.5 w-3.5 text-blue-700"></i>
                  {{ $u->reading_logs_count }} kali
                </span>
              </td>

              <!-- Registered Date -->
              <td class="py-3.5 px-4 text-center text-slate-500 whitespace-nowrap text-[11px]">
                {{ $u->created_at->format('d/m/Y') }}
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-center whitespace-nowrap">
                <div class="inline-flex items-center gap-1">
                  <!-- Detail Button -->
                  <a 
                    href="{{ route('admin.users.show', $u) }}"
                    class="rounded-lg p-1.5 text-slate-500 hover:bg-blue-50 hover:text-blue-700 transition"
                    title="Lihat Detail & Riwayat Pengguna"
                  >
                    <i data-lucide="info" class="h-4 w-4"></i>
                  </a>

                  <!-- Edit Button -->
                  <a 
                    href="{{ route('admin.users.edit', $u) }}" 
                    class="rounded-lg p-1.5 text-slate-500 hover:bg-amber-50 hover:text-amber-700 transition"
                    title="Edit Pengguna"
                  >
                    <i data-lucide="edit-3" class="h-4 w-4"></i>
                  </a>

                  <!-- Toggle Active / Inactive Status Form -->
                  <form action="{{ route('admin.users.toggle_status', $u) }}" method="POST" class="inline">
                    @csrf
                    <button 
                      type="submit" 
                      class="rounded-lg p-1.5 {{ $u->status === 'active' ? 'text-slate-500 hover:bg-amber-50 hover:text-amber-700' : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-700' }} transition"
                      title="{{ $u->status === 'active' ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}"
                    >
                      <i data-lucide="{{ $u->status === 'active' ? 'user-x' : 'user-check' }}" class="h-4 w-4"></i>
                    </button>
                  </form>

                  <!-- Delete Button -->
                  @if($u->id !== Auth::id())
                    <button 
                      type="button" 
                      onclick="openDeleteUserModal('{{ route('admin.users.destroy', $u) }}', '{{ addslashes($u->name) }}')"
                      class="rounded-lg p-1.5 text-slate-500 hover:bg-rose-50 hover:text-rose-700 transition"
                      title="Hapus Pengguna"
                    >
                      <i data-lucide="trash-2" class="h-4 w-4"></i>
                    </button>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="py-12 text-center text-slate-400">
                <div class="flex flex-col items-center justify-center">
                  <i data-lucide="users" class="h-10 w-10 text-slate-300 mb-2"></i>
                  <p class="font-bold text-slate-600">Tidak ada pengguna yang ditemukan</p>
                  <p class="text-xs text-slate-400 mt-0.5">Coba gunakan kata kunci pencarian yang berbeda.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
      <div class="border-t border-slate-100 p-4">
        {{ $users->links() }}
      </div>
    @endif
  </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteUserModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
  <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl transition transform">
    <div class="flex items-center gap-3 text-rose-600 mb-4">
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50">
        <i data-lucide="alert-triangle" class="h-5 w-5"></i>
      </span>
      <h3 class="text-base font-extrabold text-slate-900">Konfirmasi Hapus Pengguna</h3>
    </div>

    <p class="text-xs text-slate-600 leading-relaxed">
      Apakah Anda yakin ingin menghapus akun pengguna berikut? Seluruh riwayat aktivitas baca terkait juga akan terpengaruh.
    </p>

    <div class="my-4 rounded-xl bg-slate-50 border border-slate-200 p-3">
      <p id="deleteUserName" class="text-xs font-bold text-slate-800"></p>
    </div>

    <form id="deleteUserForm" method="POST" action="">
      @csrf
      @method('DELETE')
      <div class="flex items-center justify-end gap-2.5">
        <button 
          type="button" 
          onclick="closeDeleteUserModal()" 
          class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition"
        >
          Batal
        </button>
        <button 
          type="submit" 
          class="inline-flex items-center gap-1.5 rounded-xl bg-rose-600 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-rose-700 transition"
        >
          <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
          <span>Ya, Hapus Pengguna</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function openDeleteUserModal(deleteUrl, userName) {
    const modal = document.getElementById('deleteUserModal');
    const form = document.getElementById('deleteUserForm');
    const nameEl = document.getElementById('deleteUserName');

    form.action = deleteUrl;
    nameEl.textContent = userName;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeDeleteUserModal() {
    const modal = document.getElementById('deleteUserModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>
@endpush
