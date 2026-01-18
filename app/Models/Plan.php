<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'status'
    ];

    public function microempresas()
    {
        return $this->hasMany(Microempresa::class);  // Relación uno a muchos con el modelo Microempresa
    }
}
