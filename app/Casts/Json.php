<?php
    namespace App\Casts;
    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

    class Json implements CastsAttributes
    {

        public function get($model, string $key, $value, array $attributes)
        {
            return json_decode($value,JSON_UNESCAPED_UNICODE);
        }

        public function set($model, string $key, $value, array $attributes)
        {
            return json_encode($value,JSON_UNESCAPED_UNICODE);
        }
    }
