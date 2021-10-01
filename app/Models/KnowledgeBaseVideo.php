<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Spatie\Tags\HasTags;
use BeyondCode\Comments\Traits\HasComments;


/**
 *
 */
class KnowledgeBaseVideo extends Model implements ReactableInterface
{
    use HasFactory, Reactable, HasTags, HasComments, Reactable;

    /**
     * @var string
     */
    protected $table = 'knowledgebase_videos';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'en_name', 'src', 'poster', 'description', 'en_description', 'rating', 'category', 'published', 'video_id'
    ];
}
