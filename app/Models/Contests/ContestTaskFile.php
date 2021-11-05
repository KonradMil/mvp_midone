<?php

namespace App\Models\Contests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestTaskFile extends Model
{
    use HasFactory;

    protected $table = 'content_task_file';

    protected $fillable = [
      'name', 'extension', 'path'
    ];


    public function task()
    {
        return $this->belongsTo(ContestTask::class, 'task_id');
    }
}
