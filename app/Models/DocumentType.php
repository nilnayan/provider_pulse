<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function findAll()
    {
        return self::select('id', 'name', 'description', 'allowed_formats', 'updated_at')
            ->orderBy('name')
            ->get();
    }
}
