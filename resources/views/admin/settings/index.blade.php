@extends('layouts.admin')

@section('page_title', 'Pengaturan Galeri & Rekening Bank')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Store Profile Settings -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-6">
        <div class="border-b border-gray-100 pb-3">
            <h3 class="font-serif text-base font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-store text-batik-gold"></i>
                <span>Profil Galeri & Toko Online</span>
            </h3>
            <p class="text-xs text-gray-500 mt-1">Informasi ini akan ditampilkan pada header, footer web, dan invoice pelanggan.</p>
        </div>

        <form method="POST" action="{{ route('admin.settings.store') }}" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Toko / Galeri <span class="text-rose-500">*</span></label>
                <input type="text" name="store_name" value="{{ $settings['store_name'] ?? 'Batik Gendis Ayu' }}" required
                       class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Tagline Slogan</label>
                <input type="text" name="tagline" value="{{ $settings['tagline'] ?? '' }}"
                       class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none"
                       placeholder="Pesona Keanggunan Batik Nusantara...">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Telepon</label>
                    <input type="text" name="phone" value="{{ $settings['phone'] ?? '' }}"
                           class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">No. WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}"
                           class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Email Toko</label>
                <input type="email" name="email" value="{{ $settings['email'] ?? '' }}"
                       class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Lengkap Galeri</label>
                <textarea name="address" rows="3"
                          class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">{{ $settings['address'] ?? '' }}</textarea>
            </div>

            <div>
                <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Singkat Profil</label>
                <textarea name="description" rows="3"
                          class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">{{ $settings['description'] ?? '' }}</textarea>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-batik-gold hover:bg-batik-goldHover text-gray-900 font-bold py-3 px-6 rounded-xl shadow-sm transition text-xs uppercase tracking-wider">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Profil Toko</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Bank Accounts Management -->
    <div class="space-y-6">
        <!-- List Existing Banks -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-4">
            <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                <div>
                    <h3 class="font-serif text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-building-columns text-batik-gold"></i>
                        <span>Rekening Bank Resmi Toko</span>
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Tujuan transfer pembayaran checkout pesanan.</p>
                </div>
                <span class="text-xs bg-amber-50 text-amber-900 font-bold px-2.5 py-1 rounded-full border border-amber-200">
                    {{ $bankAccounts->count() }} Rekening
                </span>
            </div>

            <div class="space-y-3">
                @foreach($bankAccounts as $bank)
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-sm text-gray-800 block">{{ $bank->bank_name }}</span>
                            <span class="font-mono text-base font-bold text-amber-950">{{ $bank->account_number }}</span>
                            <span class="text-xs text-gray-500 block">a.n. {{ $bank->account_holder }}</span>
                        </div>
                        <form method="POST" action="{{ route('admin.settings.bank.destroy', $bank) }}" onsubmit="return confirm('Hapus rekening bank ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-700 p-2" title="Hapus Rekening">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add New Bank Account Form -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-4">
            <h3 class="font-serif text-sm font-bold text-gray-900 border-b border-gray-100 pb-2 flex items-center gap-2">
                <i class="fa-solid fa-plus text-batik-gold"></i>
                <span>Tambah Rekening Bank Baru</span>
            </h3>

            <form method="POST" action="{{ route('admin.settings.bank.store') }}" class="space-y-3 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Bank <span class="text-rose-500">*</span></label>
                    <input type="text" name="bank_name" required placeholder="Contoh: Bank Syariah Indonesia (BSI)"
                           class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Nomor Rekening <span class="text-rose-500">*</span></label>
                    <input type="text" name="account_number" required placeholder="Contoh: 7129-019-281"
                           class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none font-mono">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 uppercase tracking-wider mb-1">Atas Nama (Pemilik) <span class="text-rose-500">*</span></label>
                    <input type="text" name="account_holder" required placeholder="Contoh: Batik Gendis Ayu"
                           class="w-full text-sm p-3 border border-gray-200 rounded-xl focus:border-batik-gold outline-none">
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-batik-brown text-batik-gold hover:bg-batik-dark font-bold py-2.5 px-5 rounded-xl shadow-sm transition text-xs">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Rekening</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
