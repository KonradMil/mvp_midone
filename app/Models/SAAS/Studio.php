<?php

namespace App\Models\SAAS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Studio extends Model
{
    use HasFactory;

    protected $table = 'studios';

    protected $fillable = [
        'name', 'organization_name', 'organization_logo', 'organization_slug',
        'email_regexp', 'max_users', 'paid'
    ];

    protected $casts = [
        'name' => 'string',
        'organization_name' => 'string',
        'organization_logo' => 'string',
        'email_regexp' => 'string',
        'max_users' => 'integer',
        'paid' => 'boolean'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(StudioUser::class);
    }

    public function saves(): HasMany
    {
        return $this->hasMany(StudioSave::class);
    }

}
