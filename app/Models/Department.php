<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function findAll()
    {
        return self::select('id', 'name', 'updated_at')
            ->orderBy('name')
            ->get();
    }

    public static function getOptions(bool $nullable = true): array
    {
        $options = $nullable ? [null => null] : [];

        return $options + self::all()->pluck('id', 'name')->sortBy('id')->toArray();
    }
}
