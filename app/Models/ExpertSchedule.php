<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertSchedule extends Model
{
    protected $fillable = ['hair_expert_id', 'date', 'time_slot', 'is_booked'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_booked' => 'boolean',
        ];
    }

    public function expert()
    {
        return $this->belongsTo(HairExpert::class, 'hair_expert_id');
    }

    public function booking()
    {
        return $this->hasOne(ConsultationBooking::class);
    }
}
