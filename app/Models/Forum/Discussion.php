<?php

namespace App\Models\Forum;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'chatter_discussions';
    protected $fillable = ['title', 'category_id', 'color', 'last_reply_at'];
    protected $dates = ['deleted_at', 'last_reply_at'];

    public function user()
    {
        return $this->belongsTo(config('chatter.user.namespace'));
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'discussion_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'chatter_user_discussion', 'discussion_id', 'user_id');
    }


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
