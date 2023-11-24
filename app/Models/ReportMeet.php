<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportMeet extends Model
{
    use HasFactory;

    protected $fillable = [
        'meet_id',
        'user_id',
    ];

    public function meet()
    {
        return $this->belongsTo(Meet::class);
    }
}
