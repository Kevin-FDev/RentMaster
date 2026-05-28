<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
    ];

    // Indica que as datas devem ser tratadas como objetos Carbon (facilita formatar data depois)
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relacionamento: Uma locação pertence a um Usuário (Cliente)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento: Uma locação pertence a um Produto (Equipamento)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
