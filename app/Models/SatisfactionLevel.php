<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatisfactionLevel extends Model
{
    use HasFactory;

    public static function getOptions(bool $nullable = true): array
    {
        $options = $nullable ? [null => null] : [];

        return $options + self::all()->pluck('id', 'name')->sortBy('id')->toArray();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
