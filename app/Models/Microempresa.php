<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Microempresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'user_id',
        'plan_id',
        'direccion',
        'telefono',
        'nit',
        'estado',
        'logo',  // Añadido para el logo
        'horario_atencion',  // Añadido para el horario de atención
    ];

    // Relación con el usuario (dueño de la microempresa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el plan seleccionado
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}