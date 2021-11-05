<?php

namespace App\Models\Showrooms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowroomFile extends Model
{
    use HasFactory;

    protected $table = 'showroom_files';


    protected $fillable = [
        'name', 'ext', 'original_name', 'path', 'size', 'alt', 'showroom_id'
    ];

    public function showroom()
    {
        return $this->belongsTo(Showroom::class);
    }

}
