<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLevel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getOptions(bool $nullable = true): array
    {
        $options = $nullable ? [null => null] : [];

        return $options + self::all()->pluck('id', 'name')->sortBy('id')->toArray();
    }
}
