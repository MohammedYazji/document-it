<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $connection = 'sqlite';

    protected $primaryKey = 'name';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'value',
        'group',
        'cached',
    ];

    public static function getValue(string $name, $default = null): mixed
    {
        $key = "setting_{$name}";

        // Version 1: Cache::remember (active)
        // return Cache::remember($key, 3600, function () use ($name, $default) {
        //     return self::query()->where('name', $name)->value('value') ?? $default;
        // });

        // Version 2: Cache::get/put
        $value = Cache::get($key);
        if ($value === null) {
            $value = self::query()->where('name', $name)->value('value') ?? $default;
            Cache::put($key, $value, 3600);
        }
        return $value;
    }
}
