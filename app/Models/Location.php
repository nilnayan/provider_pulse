<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public static function findAll()
    {
        return self::select('*')
            ->orderBy('name')
            ->get();
    }

    public static function getOptions(bool $nullable = true): array
    {
        $options = $nullable ? [null => null] : [];

        return $options + self::all()->pluck('id', 'name')->sortBy('id')->toArray();
    }
}
