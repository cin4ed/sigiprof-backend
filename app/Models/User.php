<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    /**
     * Get the publications for the user.
     */
    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'publicaciones_usuarios', 'usuario_id', 'publicacion_id')
            ->withPivot('rol')
            ->withTimestamps();
    }

    /**
     * Get the books for the user.
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'libros_usuarios', 'usuario_id', 'libro_id')
            ->withPivot('rol')
            ->withTimestamps();
    }

    /**
     * Get the courses for the user.
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'usuario_id');
    }
}
