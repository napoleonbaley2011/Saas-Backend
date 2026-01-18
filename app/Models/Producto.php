<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables de manera masiva.
     *
     * @var array<string>
     */
    protected $fillable = [
        'descripcion',
        'unidad',
        'stock',
        'cantidad_minima',
        'precio',
        'user_id',
    ];

    /**
     * Obtener el usuario (microempresa) al que pertenece el producto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);  // Relación inversa con el modelo User
    }
}
