<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'city',
        'province',
        'postal_code',
        'courier',
        'tracking_number',
        'subtotal',
        'shipping_cost',
        'total_amount',
        'payment_method',
        'payment_status',
        'payment_proof',
        'payment_date',
        'order_status',
        'customer_notes',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'payment_date' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getFormattedShippingCostAttribute(): string
    {
        return 'Rp ' . number_format($this->shipping_cost, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->order_status) {
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Diproses / Dikemas',
            'shipped' => 'Dalam Pengiriman',
            'completed' => 'Pesanan Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->order_status),
        };
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->order_status) {
            'pending' => 'bg-amber-100 text-amber-800 border-amber-300',
            'processing' => 'bg-blue-100 text-blue-800 border-blue-300',
            'shipped' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
            'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-gray-100 text-gray-800 border-gray-300',
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'unpaid' => 'Belum Dibayar',
            'pending_verification' => 'Menunggu Verifikasi Admin',
            'paid' => 'Lunas (Terverifikasi)',
            'failed' => 'Pembayaran Ditolak',
            default => ucfirst($this->payment_status),
        };
    }

    public function getPaymentBadgeColorAttribute(): string
    {
        return match ($this->payment_status) {
            'unpaid' => 'bg-rose-100 text-rose-800 border-rose-300',
            'pending_verification' => 'bg-amber-100 text-amber-800 border-amber-300',
            'paid' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'failed' => 'bg-gray-100 text-gray-800 border-gray-300',
            default => 'bg-gray-100 text-gray-800 border-gray-300',
        };
    }
}
