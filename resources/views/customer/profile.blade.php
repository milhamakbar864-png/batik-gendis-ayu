@extends('layouts.app')
@section('title', 'Profil Akun Saya - Batik Gendis Ayu')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="font-serif text-3xl font-bold text-gray-900">Profil Akun Saya</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola informasi pribadi dan ubah kata sandi akun Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('customer.orders') }}" class="text-xs font-semibold px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition">Pesanan Saya</a>
            <a href="{{ route('customer.profile') }}" class="text-xs font-bold px-4 py-2 rounded-xl bg-batik-brown text-batik-gold border border-batik-gold/40">Profil Akun</a>
        </div>
    </div>

    <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-6">
        @csrf
        <!-- Profile Info -->
        <div class="bg-white p-6 rounded-2xl border border-amber-100 shadow-sm space-y-5">
            <h3 class="font-serif text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2"><i class="fa-solid fa-user text-batik-gold"></i> Informasi Pribadi</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Email (Tidak Dapat Diubah)</label>
                    <input type="email" value="{{ $user->email }}" readonly class="w-full text-sm p-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">No. WhatsApp / HP <span class="text-rose-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kota / Kabupaten</label>
                    <input type="text" name="city" value="{{ old('city', $user->city) }}" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Lengkap</label>
                    <textarea name="address" rows="2" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none">{{ old('address', $user->address) }}</textarea>
                </div>
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kode Pos</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none">
                </div>
            </div>
        </div>

        <!-- Password Change -->
        <div class="bg-white p-6 rounded-2xl border border-amber-100 shadow-sm space-y-5">
            <h3 class="font-serif text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2"><i class="fa-solid fa-lock text-batik-gold"></i> Ubah Kata Sandi (Opsional)</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Sandi Saat Ini</label>
                    <input type="password" name="current_password" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none" placeholder="••••••">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Sandi Baru</label>
                    <input type="password" name="new_password" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none" placeholder="Min. 6 karakter">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1.5">Konfirmasi Sandi Baru</label>
                    <input type="password" name="new_password_confirmation" class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500/20 focus:border-batik-gold outline-none" placeholder="Ketik ulang">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold py-3 px-8 rounded-full shadow-md hover:shadow-lg transition text-xs uppercase tracking-wider">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
