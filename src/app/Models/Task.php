<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_content',
        'deadline',
        'study_time',
        'total_study_time',
        'progress',
        'completed',
        'test_id',
        'subject_id',
        'user_id',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'deadline' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function getFormattedDeadlineAttribute(): string
    {
        return Carbon::parse($this->deadline)->format('n/j');
    }

    public function getFormattedDeadlineForInputAttribute(): string
    {
        return Carbon::parse($this->deadline)->format('Y-m-d');
    }

    public function setDeadlineAttribute(string $value): void
    {
        $this->attributes['deadline'] = Carbon::createFromFormat('Y-m-d', $value);
    }
}
