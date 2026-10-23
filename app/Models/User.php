<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    public function kritik()
    {
        return $this->hasMany(Kritik::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        if ($this->email === 'admin@gmail.com') {
            return true;
        }

        if (isset($this->role) && is_object($this->role) && isset($this->role->name)) {
            return $this->role->name === 'admin';
        }

        if (property_exists($this, 'role_name') && $this->role_name === 'admin') {
            return true;
        }

        return false;
    }
}
