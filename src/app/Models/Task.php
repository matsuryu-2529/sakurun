<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_content',
        'deadline',
        'study_time',
        'progress',
        'updated_date',
        'completed',
        'test_id',
        'subject_id',
        'user_id',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'updated_date' => 'datetime',
        'deadline' => 'datetime',
    ];

    protected $dates = ['deadline'];

    public function getFormattedDeadlineAttribute()
    {
        return Carbon::parse($this->deadline)->format('n/j');
    }

    public function getFormattedDeadlineForInputAttribute()
    {
        return Carbon::parse($this->deadline)->format('Y-m-d');
    }

    public function setDeadlineAttribute($value)
    {
        $this->attributes['deadline'] = Carbon::createFromFormat('Y-m-d', $value);
    }
}
