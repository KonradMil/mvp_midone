<?php

namespace App\Models\Forum;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'chatter_posts';
    protected $fillable = ['body', 'markdown', 'discussion_id'];
    protected $dates = ['deleted_at'];
    protected $touches = ['discussion'];

    public $timestamps = true;

    public function discussion()
    {
        return $this->belongsTo(Discussion::class, 'discussion_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
