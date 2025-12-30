<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['test_name', 'year'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'test_subjects', 'test_id', 'subject_id');
    }
}
