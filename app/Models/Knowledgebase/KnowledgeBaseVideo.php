<?php

namespace App\Models\Knowledgebase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Spatie\Tags\HasTags;
use BeyondCode\Comments\Traits\HasComments;

class KnowledgeBaseVideo extends Model implements ReactableInterface
{
    use HasFactory, Reactable, HasTags, HasComments, Reactable;

    protected $table = 'knowledgebase_videos';

    protected $fillable = [
      'name', 'en_name', 'src', 'poster', 'description', 'en_description', 'rating', 'category', 'published'
    ];
}
