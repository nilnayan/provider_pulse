<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class UserNote extends Model
{
    use HasFactory, SoftDeletes;

    public static int $per_page = 10;
    protected $guarded = [];

    public static function findAll(Request $request): LengthAwarePaginator
    {
        return self::query()
            ->when($request->input('search_term'), function($query, $search_term) {
                $query->where('content', 'like', "%$search_term%");
            })
            ->when($request->input('start_dt'), function($query, $start_dt) {
                $query->where('created_at', '>=', $start_dt);
            })
            ->when($request->input('end_dt'), function($query, $end_dt) {
                $query->where('created_at', '<=', $end_dt);
            })
            ->with(['user'])
            ->orderBy('updated_at', 'desc')
            ->paginate(self::$per_page)
            ->withQueryString();
    }

    public static function findByUser(User $user, Request $request)//: LengthAwarePaginator
    {
        return self::query()
            ->when($request->input('search_term'), function($query, $search_term) {
                $query->where('content', 'like', "%$search_term%");
            })
            ->when($request->input('start_dt'), function($query, $start_dt) {
                $query->where('created_at', '>=', $start_dt);
            })
            ->when($request->input('end_dt'), function($query, $end_dt) {
                $query->where('created_at', '<=', $end_dt);
            })
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
//            ->toSql();
            ->paginate(self::$per_page)
            ->withQueryString();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
