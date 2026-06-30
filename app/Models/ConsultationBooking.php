<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationBooking extends Model
{
    protected $fillable = [
        'user_id',
        'hair_expert_id',
        'expert_schedule_id',
        'type',
        'complaint',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expert()
    {
        return $this->belongsTo(HairExpert::class, 'hair_expert_id');
    }

    public function schedule()
    {
        return $this->belongsTo(ExpertSchedule::class, 'expert_schedule_id');
    }
}
