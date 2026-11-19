<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Batik Gendis Ayu
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');

// Shop & Catalog
Route::get('/katalog', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produk/{slug}', [ShopController::class, 'show'])->name('shop.show');

// Shopping Cart
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
Route::post('/keranjang/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/keranjang/hapus', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/keranjang/kosongkan', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

// Order Tracking & Payment
Route::get('/lacak-pesanan', [OrderTrackingController::class, 'track'])->name('order.track');
Route::get('/pesanan/{orderNumber}/pembayaran', [OrderTrackingController::class, 'payment'])->name('order.payment');
Route::post('/pesanan/{orderNumber}/upload-bukti', [OrderTrackingController::class, 'uploadProof'])->name('order.uploadProof');
Route::get('/pesanan/{orderNumber}', [OrderTrackingController::class, 'detail'])->name('order.detail');
Route::get('/pesanan/{orderNumber}/invoice', [OrderTrackingController::class, 'invoice'])->name('order.invoice');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer Dashboard Routes (Auth Required)
Route::middleware('auth')->prefix('akun')->name('customer.')->group(function () {
    Route::get('/pesanan-saya', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/profil', [CustomerController::class, 'profile'])->name('profile');
    Route::post('/profil', [CustomerController::class, 'updateProfile'])->name('profile.update');
});

// Admin Panel Routes (Auth & Admin Middleware Required)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Categories Management
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Products Management
    Route::resource('products', ProductController::class);

    // Inventory Management (Inti Skripsi Manajemen Persediaan)
    Route::get('/persediaan', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/persediaan/masuk', [InventoryController::class, 'createStockIn'])->name('inventory.stockIn');
    Route::post('/persediaan/masuk', [InventoryController::class, 'storeStockIn'])->name('inventory.storeStockIn');
    Route::get('/persediaan/keluar', [InventoryController::class, 'createStockOut'])->name('inventory.stockOut');
    Route::post('/persediaan/keluar', [InventoryController::class, 'storeStockOut'])->name('inventory.storeStockOut');
    Route::get('/persediaan/mutasi', [InventoryController::class, 'movements'])->name('inventory.movements');
    Route::get('/persediaan/peringatan-stok', [InventoryController::class, 'alerts'])->name('inventory.alerts');

    // Orders Management
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{order}/verifikasi-pembayaran', [OrderController::class, 'verifyPayment'])->name('orders.verifyPayment');
    Route::post('/pesanan/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/pesanan/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

    // Comprehensive Reports (Laporan Skripsi)
    Route::get('/laporan/penjualan', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/laporan/persediaan', [ReportController::class, 'inventory'])->name('reports.inventory');

    // Store & Bank Settings
    Route::get('/pengaturan', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/pengaturan/toko', [SettingController::class, 'updateStore'])->name('settings.store');
    Route::post('/pengaturan/bank', [SettingController::class, 'storeBank'])->name('settings.bank.store');
    Route::delete('/pengaturan/bank/{bankAccount}', [SettingController::class, 'destroyBank'])->name('settings.bank.destroy');
});
