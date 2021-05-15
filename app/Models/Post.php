<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $table = 'posts';
    protected $fillable = [
        'wp_id', 'status', 'title', 'slug', 'type_investor', 'type_installer', 'excerpt', 'thumbnail', 'content'
    ];

}
