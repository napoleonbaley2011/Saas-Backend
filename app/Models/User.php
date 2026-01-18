<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();  // Generalmente, devuelve el ID del usuario
    }

    /**
     * Obtener los valores personalizados para el JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];  // Aquí puedes agregar más claims personalizados si lo deseas
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);  // Relación uno a muchos con el modelo Producto
    }

    public function microempresas()
    {
        return $this->hasMany(Microempresa::class);  // Relación uno a muchos con el modelo Microempresa
    }
}
