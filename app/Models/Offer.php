<?php

namespace App\Models;

use App\Models\Challenges\Challenge;
use App\Models\Solutions\Solution;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    public $table = 'offers';

    protected $fillable = [
        'price', 'guarantee_period', 'start_date', 'start_weeks', 'br_cost', 'period_of_support',
        'advance_after_contract', 'advance_during_installation', 'advance_after_start',
        'service_contract_reaction', 'response_time', 'frequency_checkup', 'price_checkup',
        'status', 'select_response_time', 'service_contract_reaction', 'recup_time', 'emergency_cost',
        'challenge_id', 'solution_id', 'installer_id', 'rejected', 'offer_expires_in', 'robots', 'avg_guarantee'
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function installer()
    {
        return $this->belongsTo(User::class);
    }
}
