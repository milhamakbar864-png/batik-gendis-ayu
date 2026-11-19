@extends('layouts.app')
@section('title', 'Daftar Akun Baru - Batik Gendis Ayu')
@section('content')
<div class="max-w-lg mx-auto px-4 py-14">
    <div class="bg-white rounded-3xl p-8 border border-amber-100 shadow-md space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-full bg-batik-brown text-batik-gold flex items-center justify-center mx-auto text-xl border border-batik-gold">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h1 class="font-serif text-2xl font-bold text-gray-900">Daftar Akun Pelanggan</h1>
            <p class="text-xs text-gray-500">Buat akun untuk menikmati kemudahan berbelanja batik nusantara.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none" placeholder="Nama lengkap Anda">
            </div>
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Email <span class="text-rose-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none" placeholder="email@contoh.com">
            </div>
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">No. WhatsApp / Telepon <span class="text-rose-500">*</span></label>
                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none" placeholder="081234567890">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kata Sandi <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" required class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none" placeholder="Min. 6 karakter">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Konfirmasi Sandi <span class="text-rose-500">*</span></label>
                    <input type="password" name="password_confirmation" required class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none" placeholder="Ketik ulang sandi">
                </div>
            </div>
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Lengkap (Opsional)</label>
                <textarea name="address" rows="2" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none" placeholder="Jl. Contoh No. 10, RT 01/RW 02">{{ old('address') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kota / Kabupaten</label>
                    <input type="text" name="city" value="{{ old('city') }}" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none" placeholder="Yogyakarta">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kode Pos</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none" placeholder="55271">
                </div>
            </div>
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-batik-brown text-batik-gold hover:bg-batik-dark font-bold py-3.5 px-6 rounded-full border border-batik-gold/40 shadow-md hover:shadow-lg transition text-xs uppercase tracking-wider mt-2">
                <i class="fa-solid fa-user-check text-xs"></i> Daftar Sekarang
            </button>
        </form>
        <div class="text-center text-xs text-gray-500 pt-2 border-t border-gray-100">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-batik-gold hover:underline">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
