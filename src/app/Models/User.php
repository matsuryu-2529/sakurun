<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    protected $fillable = [
        'username',
        'year',
        'password',
        'test_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
