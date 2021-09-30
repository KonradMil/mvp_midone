<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class Offer extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public $table = 'offers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'price', 'guarantee_period', 'start_date', 'start_weeks', 'br_cost', 'period_of_support',
        'advance_after_contract', 'advance_during_installation', 'advance_after_start',
        'service_contract_reaction', 'response_time', 'frequency_checkup', 'price_checkup',
        'status', 'select_response_time', 'service_contract_reaction', 'recup_time', 'emergency_cost',
        'challenge_id', 'solution_id', 'installer_id', 'rejected', 'offer_expires_in', 'robots', 'avg_guarantee', 'points',
        'count_fanuc', 'count_yaskawa', 'count_abb', 'count_mitshubishi', 'count_tfm', 'count_universal', 'count_kuka',
        'comment', 'is_offer_project', 'project_id'
    ];

    /**
     * @return BelongsTo
     */
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    /**
     * @return BelongsTo
     */
    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class);
    }

    /**
     * @return BelongsTo
     */
    public function installer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
