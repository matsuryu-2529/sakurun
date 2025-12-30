<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['subject_name'];

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'test_subjects', 'subject_id', 'test_id');
    }
}
