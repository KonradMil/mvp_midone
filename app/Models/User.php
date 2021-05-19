<?php

namespace App\Models;

use App\Models\Challenges\Challenge;
use App\Models\Reports\Report;
use App\Models\Solutions\Solution;
use BeyondCode\Comments\Contracts\Commentator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cog\Contracts\Love\Reacterable\Models\Reacterable as ReacterableInterface;
use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;
use Mpociot\Teamwork\Traits\UserHasTeams;

class User extends Authenticatable implements ReacterableInterface, Commentator
{
    use HasFactory, Notifiable, Reacterable, UserHasTeams;

    public function needsCommentApproval($model): bool
    {
        return false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'verified',
        'verified_at',
        'role',
        'avatar',
        'privacy_policy',
        'pricing',
        'terms',
        'company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class, 'author_id');
    }

    public function challenges()
    {
        return $this->belongsTo(Challenge::class, 'author_id');
    }

    public function solutions()
    {
        return $this->belongsTo(Solution::class, 'author_id');
    }

    public function own_company() {
        return $this->hasOne(Company::class, 'author_id');
    }

    public function companies() {
        return $this->belongsToMany(Company::class, 'user_companies', 'company_id', 'user_id')->withTimestamps();
    }

}
