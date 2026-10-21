@extends('admin.layouts.app')

@section('title', 'Edit Pengguna - ' . $user->name)
@section('header_title', 'Perbarui Data Pengguna')
@section('header_subtitle', 'Ubah rincian profil, peran, status, atau kata sandi pengguna.')

@section('content')
<div class="max-w-2xl mx-auto">
  <div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 hover:underline">
      <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
      <span>Kembali ke Daftar Pengguna</span>
    </a>
  </div>

  <div class="rounded-2xl bg-white p-6 sm:p-8 border border-slate-200/90 shadow-xs">
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
      <div>
        <h2 class="text-base font-extrabold text-[#082b62]">Edit Pengguna: {{ $user->name }}</h2>
        <p class="text-xs text-slate-400 mt-0.5">ID: #{{ $user->id }} &bull; Bergabung: {{ $user->created_at->format('d M Y') }}</p>
      </div>

      <a 
        href="{{ route('admin.users.show', $user) }}" 
        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition"
      >
        <i data-lucide="eye" class="h-3.5 w-3.5 text-slate-500"></i>
        <span>Detail</span>
      </a>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-5">
      @csrf
      @method('PUT')

      <!-- Nama Lengkap -->
      <div>
        <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">
          Nama Lengkap <span class="text-rose-500">*</span>
        </label>
        <input 
          type="text" 
          name="name" 
          id="name" 
          value="{{ old('name', $user->name) }}" 
          required 
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
        @error('name')
          <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
        @enderror
      </div>

      <!-- Email & Phone -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
            Alamat Email <span class="text-rose-500">*</span>
          </label>
          <input 
            type="email" 
            name="email" 
            id="email" 
            value="{{ old('email', $user->email) }}" 
            required 
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
          @error('email')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="phone" class="block text-xs font-bold text-slate-700 mb-1.5">
            Nomor Telepon / WhatsApp
          </label>
          <input 
            type="text" 
            name="phone" 
            id="phone" 
            value="{{ old('phone', $user->phone) }}" 
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
          @error('phone')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- Password Optional -->
      <div>
        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">
          Ganti Kata Sandi (Opsional)
        </label>
        <input 
          type="password" 
          name="password" 
          id="password" 
          placeholder="Kosongkan jika tidak ingin mengubah password"
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
        <p class="text-[11px] text-slate-400 mt-1">Isi hanya jika ingin mengubah kata sandi pengguna.</p>
        @error('password')
          <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
        @enderror
      </div>

      <!-- Role & Status -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
        <div>
          <label for="role" class="block text-xs font-bold text-slate-700 mb-1.5">
            Peran Pengguna (Role) <span class="text-rose-500">*</span>
          </label>
          <select 
            name="role" 
            id="role" 
            required 
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Anggota / Pembaca (User)</option>
            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator (Akses Dashboard)</option>
          </select>
          @error('role')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="status" class="block text-xs font-bold text-slate-700 mb-1.5">
            Status Akun <span class="text-rose-500">*</span>
          </label>
          <select 
            name="status" 
            id="status" 
            required 
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
            <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
          </select>
          @error('status')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
        <a 
          href="{{ route('admin.users.index') }}" 
          class="rounded-xl border border-slate-200 px-5 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition"
        >
          Batal
        </a>
        <button 
          type="submit" 
          class="inline-flex items-center gap-2 rounded-xl bg-[#082b62] px-6 py-2.5 text-xs font-extrabold text-white shadow-md hover:bg-blue-900 transition active:scale-98"
        >
          <i data-lucide="check" class="h-4 w-4"></i>
          <span>Simpan Perubahan</span>
        </button>
      </div>

    </form>
  </div>
</div>
@endsection
