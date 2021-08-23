<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 *
 */
class UnityModel extends Model
{
    /**
     * @var string
     */
    public $table = 'models';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'category', 'subcategory', 'price',
        'model_file', 'brand', 'model', 'max_load_kg',
        'max_range_mm', 'axis', 'max_speed_mms', 'tech_sheet', 'connection_method', 'range', 'repetity', 'load'
    ];


    /**
     * @return BelongsTo
     */
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

}
