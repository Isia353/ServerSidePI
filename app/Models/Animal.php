<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        "description",
        "sex",
        "name",
        "img",
        "conservation_state",
        "zone_id"
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
