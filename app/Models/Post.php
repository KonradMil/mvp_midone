<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Post extends Model
{
    /**
     * @var string
     */
    public $table = 'posts';

    /**
     * @var string[]
     */
    protected $fillable = [
        'wp_id', 'status', 'title', 'slug', 'type_investor', 'type_installer', 'excerpt', 'thumbnail', 'content'
    ];

}
