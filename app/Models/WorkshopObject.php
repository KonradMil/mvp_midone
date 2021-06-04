<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopObject extends Model
{
    use HasFactory;

    public $table = 'workshop_objects';

    protected $fillable = [
        'save', 'name', 'author_id', 'screenshot_path', 'public'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_workshop_objects', 'workshop_object_id', 'author_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
