<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapMarker extends Model
{
    use HasFactory;

    public $table = 'markers';

    public $fillable = [
        'lat', 'lng', 'timestamp'
    ];
}
