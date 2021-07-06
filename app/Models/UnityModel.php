<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UnityModel extends Model
{
    public $table = 'models';
    protected $fillable = [
        'name', 'category', 'subcategory', 'price',
        'model_file', 'brand', 'model', 'max_load_kg',
        'max_range_mm', 'axis', 'max_speed_mms', 'tech_sheet', 'connection_method', 'range', 'repetity', 'load', 'guarantee_period'
    ];


    public function file()
    {
        return $this->belongsTo(File::class);
    }

}
