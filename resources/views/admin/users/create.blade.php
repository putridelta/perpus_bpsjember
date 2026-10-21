@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna Baru')
@section('header_title', 'Tambah Pengguna Baru')
@section('header_subtitle', 'Daftarkan administrator baru atau anggota pembaca perpustakaan.')

@section('content')
<div class="max-w-2xl mx-auto">
  <div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 hover:underline">
      <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
      <span>Kembali ke Daftar Pengguna</span>
    </a>
  </div>

  <div class="rounded-2xl bg-white p-6 sm:p-8 border border-slate-200/90 shadow-xs">
    <div class="border-b border-slate-100 pb-4 mb-6">
      <h2 class="text-base font-extrabold text-[#082b62]">Formulir Pendaftaran Pengguna</h2>
      <p class="text-xs text-slate-400 mt-0.5">Tentukan peran akun dan akses login ke sistem.</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
      @csrf

      <!-- Nama Lengkap -->
      <div>
        <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">
          Nama Lengkap <span class="text-rose-500">*</span>
        </label>
        <input 
          type="text" 
          name="name" 
          id="name" 
          value="{{ old('name') }}" 
          required 
          placeholder="Contoh: Ahmad Fauzi"
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
            value="{{ old('email') }}" 
            required 
            placeholder="fauzi@example.com"
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
            value="{{ old('phone') }}" 
            placeholder="081234567890"
            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
          >
          @error('phone')
            <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">
          Kata Sandi (Password) <span class="text-rose-500">*</span>
        </label>
        <input 
          type="password" 
          name="password" 
          id="password" 
          required 
          placeholder="Minimal 6 karakter"
          class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-blue-600 focus:bg-white focus:outline-none"
        >
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
            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Anggota / Pembaca (User)</option>
            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator (Akses Dashboard)</option>
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
            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
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
          <i data-lucide="user-plus" class="h-4 w-4"></i>
          <span>Simpan Pengguna</span>
        </button>
      </div>

    </form>
  </div>
</div>
@endsection
