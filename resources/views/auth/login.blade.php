@extends('layouts.app')

@section('title', 'Masuk Akun - Batik Gendis Ayu')

@section('content')
<div class="max-w-md mx-auto px-4 py-16"
     x-data="{
        fillAdmin() {
            document.getElementById('email').value = 'admin@batikgendisayu.com';
            document.getElementById('password').value = 'admin123';
        },
        fillCustomer() {
            document.getElementById('email').value = 'rina.kusuma@gmail.com';
            document.getElementById('password').value = 'customer123';
        }
     }">

    <div class="bg-white rounded-3xl p-8 border border-amber-100 shadow-md space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-full bg-batik-brown text-batik-gold flex items-center justify-center mx-auto text-xl border border-batik-gold">
                <i class="fa-solid fa-feather-pointed"></i>
            </div>
            <h1 class="font-serif text-2xl font-bold text-gray-900">Masuk ke Akun Anda</h1>
            <p class="text-xs text-gray-500">Silakan masukkan email dan kata sandi Anda</p>
        </div>

        <!-- Quick Demo Credentials Box for Skripsi / Testing -->
        <div class="bg-amber-50/80 p-4 rounded-2xl border border-amber-200 text-xs space-y-2">
            <div class="flex items-center gap-1.5 font-bold text-amber-900">
                <i class="fa-solid fa-key text-batik-gold"></i>
                <span>Akun Demo (Uji Coba Skripsi):</span>
            </div>
            <div class="grid grid-cols-2 gap-2 pt-1">
                <button type="button" @click="fillAdmin()"
                        class="p-2 bg-white rounded-xl border border-amber-300 hover:bg-amber-100 text-left transition shadow-xs">
                    <span class="block font-bold text-gray-800">Admin Galeri</span>
                    <span class="text-[10px] text-gray-500 font-mono">admin@batikgendisayu.com</span>
                </button>
                <button type="button" @click="fillCustomer()"
                        class="p-2 bg-white rounded-xl border border-amber-300 hover:bg-amber-100 text-left transition shadow-xs">
                    <span class="block font-bold text-gray-800">Pelanggan</span>
                    <span class="text-[10px] text-gray-500 font-mono">rina.kusuma@gmail.com</span>
                </button>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none"
                       placeholder="nama@email.com">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="font-bold text-gray-700 uppercase tracking-wider">Kata Sandi</label>
                </div>
                <input type="password" id="password" name="password" required
                       class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none"
                       placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="text-amber-600 focus:ring-amber-500 rounded">
                    <span class="text-xs text-gray-600">Ingat Saya</span>
                </label>
            </div>

            <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 bg-batik-brown text-batik-gold hover:bg-batik-dark font-bold py-3.5 px-6 rounded-full border border-batik-gold/40 shadow-md hover:shadow-lg transition text-xs uppercase tracking-wider">
                <i class="fa-solid fa-right-to-bracket text-xs"></i>
                <span>Masuk Sekarang</span>
            </button>
        </form>

        <div class="text-center text-xs text-gray-500 pt-2 border-t border-gray-100">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="font-bold text-batik-gold hover:underline">Daftar Akun Baru</a>
        </div>
    </div>
</div>
@endsection
