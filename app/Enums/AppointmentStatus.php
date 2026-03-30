<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
    case NO_SHOW = 'no_show';

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'bg-amber-100 text-amber-700',
            self::CONFIRMED => 'bg-[#4a40e0]/10 text-[#4a40e0]',
            self::COMPLETED => 'bg-emerald-100 text-emerald-700',
            self::CANCELED => 'bg-rose-100 text-rose-700',
            self::NO_SHOW => 'bg-slate-100 text-slate-700',
        };
    }
}
