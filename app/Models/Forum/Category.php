<?php

namespace App\Models\Forum;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'chatter_categories';
    public $timestamps = true;
    public $with = 'parents';

    public function discussions()
    {
        return $this->hasMany(Discussion::class, 'category_id');
    }

    public function parents()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order', 'asc');
    }
}
