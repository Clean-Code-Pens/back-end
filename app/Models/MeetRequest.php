<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meet_id',
        'status',
    ];

    public function meet()
    {
        return $this->belongsTo(Meet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
