<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'name',
        'description',
        'people_need',
        'status'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function meetRequest()
    {
        return $this->hasMany(MeetRequest::class);
    }

    public function reportMeets()
    {
        return $this->hasMany(ReportMeet::class);
    }
}
