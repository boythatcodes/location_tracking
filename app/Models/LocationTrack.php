<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationTrack extends Model
{
    protected $fillable = ["node_id", "latitude", "longitude"];
    use HasFactory;
}
