<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HairExpert extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'specialty',
        'rating',
        'price',
        'profile',
        'experience',
        'description'
    ];

    public function schedules()
    {
        return $this->hasMany(ExpertSchedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(ConsultationBooking::class);
    }
}
