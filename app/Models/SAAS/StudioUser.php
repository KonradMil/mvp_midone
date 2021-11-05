<?php

namespace App\Models\SAAS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioUser extends Model
{
    use HasFactory;

    protected $fillable = [
      'email', 'password'
    ];

    public function studio () {
        return $this->belongsTo(Studio::class, 'studio_id');
    }

    public function saves()
    {
        return $this->hasMany(StudioSave::class);
    }
}
