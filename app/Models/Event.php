<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        "description",
        "date",
        "booking",
        "zone_id"
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
