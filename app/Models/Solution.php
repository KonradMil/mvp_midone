<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Tags\HasTags;
use BeyondCode\Comments\Traits\HasComments;

/**
 *
 */
class Solution extends Model implements ReactableInterface
{
    use Reactable, HasTags, HasComments;

    /**
     * @var string
     */
    public $table = 'solutions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'deadline_offered', 'offered_installation_price', 'cycle_time', 'selected', 'rejected',
        'name', 'status', 'save_json', 'rate', 'screenshot_path',
        'installer_id', 'challenge_id', 'financial_after_id', 'author_id', 'published_at',
        'count_fanuc', 'count_yaskawa', 'count_abb', 'count_mitshubishi', 'count_tfm', 'count_universal', 'count_kuka',
    ];


    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_solution', 'solution_id', 'team_id');
    }

    /**
     * @return HasOne
     */
    public function estimate(): HasOne
    {
        return $this->hasOne(Estimate::class, 'solution_id');
    }

    /**
     * @return HasOne
     */
    public function financial_analyses(): HasOne
    {
        return $this->hasOne(FinancialAnalysis::class, 'solution_id');
    }

    /**
     * @return HasOne
     */
    public function operational_analyses(): HasOne
    {
        return $this->hasOne(OperationalAnalysis::class, 'solution_id');
    }

    /**
     * @return BelongsTo
     */
    public function challenge()
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }

    /**
     * @return HasMany
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * @return HasOne
     */
    public function financial_after(): HasOne
    {
        return $this->hasOne(Financial::class, 'id', 'financial_after_id');
    }

    /**
     * @return BelongsToMany
     */
    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'solution_files', 'solution_id', 'file_id');
    }

}
