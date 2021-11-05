<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectCommunication extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public $table = 'project_communications';

    /**
     * @var string[]
     */
    protected $fillable = [
        'project_id', 'author_id', 'personal_occupation',
        'personal_data', 'phone_number', 'email',
        'project_decision', 'is_accepted'
    ];

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'id', 'project_id');
    }
    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
