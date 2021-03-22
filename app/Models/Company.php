<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    public $table = 'companies';
    protected $fillable = [
        'company_name', 'country', 'province', 'street', 'house_nr', 'flat_nr', 'city', 'postcode',
        'nip', 'email', 'phone',
        'author_id', 'regon', 'krs'
    ];


    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_companies', 'user_id', 'company_id');
    }

}
