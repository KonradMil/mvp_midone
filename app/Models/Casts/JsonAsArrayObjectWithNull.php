<?php


namespace App\Models\Casts;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class JsonAsArrayObjectWithNull implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
         if($value == NULL) {
             return json_decode('{}');
         } else {
             return json_decode($value);
         }
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
