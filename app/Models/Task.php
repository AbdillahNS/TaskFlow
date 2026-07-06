<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'assigned_by',
        'assigned_to',
        'deadline',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
