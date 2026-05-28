<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'price_per_day', 'image', 'status'];

    // Um produto pertence a uma categoria
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Um produto pode ter muitos aluguéis ao longo do tempo (Duplicidade limpa!)
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}
