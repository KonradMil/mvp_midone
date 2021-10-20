<?php

namespace App\Models;

use App\Http\Controllers\UserController;
use BeyondCode\Comments\Contracts\Commentator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cog\Contracts\Love\Reacterable\Models\Reacterable as ReacterableInterface;
use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;

/**
 *
 */
class User extends Authenticatable implements ReacterableInterface, Commentator, MustVerifyEmail
{
    use HasFactory, Notifiable, Reacterable;

    const USER_TYPE_INVESTOR = 'investor';

    const USER_TYPE_INTEGRATOR = 'integrator';

    const USER_TYPE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone_number',
        'password',
        'phone',
        'verified',
        'verified_at',
        'role',
        'avatar',
        'privacy_policy',
        'pricing',
        'terms',
        'company_id',
        'authy_id',
        'new_answer',
        'solution_accepted',
        'offer_accepted',
        'twofa',
        'authy_id',
        'type',
        'email_verified_at',
        'google_id',
        'facebook_id',
        'avatar'
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
        'new_answer' => 'boolean',
        'solution_accepted' => 'boolean',
        'offer_accepted' => 'boolean',
        'terms' => 'boolean',
        'pricing' => 'boolean',
        'privacy_policy' => 'boolean',
    ];

    /**
     * @param mixed $model
     * @return bool
     */
    public function needsCommentApproval($model): bool
    {
        return false;
    }

    /**
     * @return BelongsToMany
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user')->withPivot('publishChallenge', 'editChallenge', 'acceptChallengeOffer', 'publishSolution', 'addSolutionOffer', 'acceptChallengeSolution', 'canEditSolution', 'canDeleteSolution', 'showSolutions')->using(TeamUser::class)->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'author_id');
    }

    /**
     * @return HasMany
     */
    public function local_visions(): HasMany
    {
        return $this->hasMany(LocalVision::class, 'author_id');
    }
    /**
     * @return HasMany
     */
    public function visit_dates(): HasMany
    {
        return $this->hasMany(VisitDate::class, 'author_id');
    }
    /**
     * @return BelongsTo
     */
    public function challenges(): BelongsTo
    {
        return $this->belongsTo(Challenge::class, 'author_id');
    }

    /**
     * @return BelongsTo
     */
    public function solutions(): BelongsTo
    {
        return $this->belongsTo(Solution::class, 'author_id');
    }

    /**
     * @return HasOne
     */
    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'author_id');
    }

    /**
     * @return BelongsToMany
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'user_companies', 'user_id', 'company_id')->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function objects(): BelongsToMany
    {
        return $this->belongsToMany(WorkshopObject::class, 'user_workshop_objects', 'author_id', 'workshop_object_id');
    }

    /**
     * @return array
     */
    public function permissions(): array
    {
        return UserController::userPermissions($this);
    }

    /**
     * @return BelongsTo
     */
    public function freeSaves(): BelongsToMany
    {
        return $this->belongsToMany(FreeSave::class, 'free_saves_user', 'user_id')->withPivot(['is_owner']);
    }

    public function ownFreeSaves()
    {
        return $this->belongsToMany(FreeSave::class, 'free_saves_user', 'user_id')->wherePivot('is_owner','=',1);
    }

    /**
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'author_id');
    }
}
