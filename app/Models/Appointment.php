<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{

    // The whitelist of columns that can be saved via Appointment::create()
    protected $fillable = [
        'user_id',
        'service_id',
        'employee_id',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'status' => AppointmentStatus::class,
        'end_time' => 'datetime',
    ];

    public function isFinalized(): bool {
        return $this->status === AppointmentStatus::COMPLETED;
    }

    // Since you are likely going to show these on the admin soon,
    // let's add the relationships now:
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function employee(): BelongsTo { return $this->belongsTo(User::class, 'employee_id'); }
    public function service(): BelongsTo { return $this->belongsTo(Service::class); }
}
