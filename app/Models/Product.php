<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sku',
        'name',
        'slug',
        'motif',
        'material',
        'technique',
        'buy_price',
        'price',
        'weight',
        'description',
        'image',
        'min_stock',
        'is_active',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'buy_price' => 'decimal:2',
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'min_stock' => 'integer',
            'weight' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalStockAttribute(): int
    {
        return (int) $this->variants()->sum('stock');
    }

    public function getStockStatusAttribute(): string
    {
        $stock = $this->total_stock;
        if ($stock <= 0) {
            return 'out_of_stock';
        }
        if ($stock <= $this->min_stock) {
            return 'low_stock';
        }
        return 'in_stock';
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedBuyPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->buy_price, 0, ',', '.');
    }
}
