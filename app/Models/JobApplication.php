<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'user_id',
        'job_title',
        'company_name',
        'status',
        'application_date',
        'notes',
        'reminder_date',
        'location',
        'job_link',
        'salary',
        'job_type',
    ];

    protected $casts = [
        'application_date' => 'datetime',
        'reminder_date' => 'datetime',
    ];
}
