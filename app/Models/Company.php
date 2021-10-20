<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Validator;


/**
 *
 */
class Company extends Model
{
    /**
     * @var string
     */
    public $table = 'companies';

    /**
     * @var string[]
     */
    protected $fillable = [
        'company_name', 'country', 'province', 'street', 'house_nr', 'flat_nr', 'city', 'postcode',
        'nip', 'email', 'phone',
        'author_id', 'regon', 'krs'
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
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_companies', 'company_id', 'user_id')->withTimestamps();
    }

    public function isDataFilled()
    {
        $validator = Validator::make($this->original, [
            'company_name' => 'required',
            'nip' => 'required',
            'regon' => 'required',
            'street' => 'required',
            'house_nr' => 'required',
            'city' => 'required',
            'postcode' => 'required'

        ]);

        return !$validator->fails();
    }

}
