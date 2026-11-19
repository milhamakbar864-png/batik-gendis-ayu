<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::all();
        $settings = StoreSetting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('bankAccounts', 'settings'));
    }

    public function updateStore(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:25',
            'whatsapp' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string',
        ]);

        foreach ($validated as $k => $v) {
            StoreSetting::set($k, $v);
        }

        return back()->with('success', 'Profil toko Batik Gendis Ayu berhasil diperbarui.');
    }

    public function storeBank(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:50',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:100',
        ]);

        $validated['is_active'] = true;

        BankAccount::create($validated);

        return back()->with('success', 'Rekening bank toko berhasil ditambahkan.');
    }

    public function destroyBank(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return back()->with('success', 'Rekening bank telah dihapus.');
    }
}
