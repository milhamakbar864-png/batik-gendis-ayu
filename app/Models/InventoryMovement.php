<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_id',
        'type',
        'reference_type',
        'reference_number',
        'quantity',
        'stock_before',
        'stock_after',
        'unit_cost',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'stock_before' => 'integer',
            'stock_after' => 'integer',
            'unit_cost' => 'decimal:2',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'in' => 'Barang Masuk (Restock)',
            'out' => 'Barang Keluar (Retur/Rusak)',
            'sale' => 'Penjualan (Checkout)',
            'adjustment' => 'Penyesuaian (Stok Opname)',
            default => ucfirst($this->type),
        };
    }

    public function getTypeBadgeColorAttribute(): string
    {
        return match ($this->type) {
            'in' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'sale' => 'bg-blue-100 text-blue-800 border-blue-300',
            'out' => 'bg-rose-100 text-rose-800 border-rose-300',
            'adjustment' => 'bg-amber-100 text-amber-800 border-amber-300',
            default => 'bg-gray-100 text-gray-800 border-gray-300',
        };
    }
}
