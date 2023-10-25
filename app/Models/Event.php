<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'event_category_id',
        'description',
        'date',
        'image',
        'place',
        'address',
        'status',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function meets()
    {
        return $this->hasMany(Meet::class);
    }
    
}
