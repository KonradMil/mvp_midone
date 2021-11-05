<?php

namespace App\Models\Showrooms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowroomSlide extends Model
{
    use HasFactory;

    protected $table = 'showroom_slide';

    /**
     *
     */
    const TYPES = [
        "text",
        "files",
        "images",
        "html"
    ];

    protected $fillable = [
        'name',
        'menu_name',
        'type',
        'content'
    ];

    public function showroom()
    {
        return $this->belongsTo(Showroom::class);
    }

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return self::TYPES[$this->attributes['type']];
    }
}
