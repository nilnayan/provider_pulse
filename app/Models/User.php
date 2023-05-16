<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static int $per_page = 10;

    /**
     * The attributes that are NOT mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function findAll(Request $request): LengthAwarePaginator
    {
        return self::query()
            ->when($request->input('search_term'), function($query, $search_term) {
                $query->where(function($q) use ($search_term) {
                    $q->where('first_name', 'like', "%$search_term%")
                        ->orWhere('last_name', 'like', "%$search_term%")
                        ->orWhere('email', 'like', "%{$search_term}%");
                });
            })
            ->with(['accessLevel', 'department', 'employeeStatus', 'jobTitle'])
            ->orderBy('first_name')
            ->paginate(self::$per_page)
            ->withQueryString();
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => bcrypt($value)
        );
    }

    protected function startDt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value = null) => $value && $value != '' ? date('m/d/Y', strtotime($value)) : null,
            set: fn (string $value = null) => $value && $value != '' ? date('Y-m-d', strtotime($value)) : null,
        );
    }

    protected function nextReviewDt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value = null) => $value ? date('m/d/Y', strtotime($value)) : null,
            set: fn (string $value = null) => $value ? date('Y-m-d', strtotime($value)) : null,
        );
    }

    public function getIdDisplay(): string
    {
        return sprintf('%05d', $this->id);
    }

    public function accessLevel(): BelongsTo
    {
        return $this->belongsTo(AccessLevel::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function employeeStatus(): BelongsTo
    {
        return $this->belongsTo(EmployeeStatus::class, 'status_id', 'id');
    }

    public function jobTitle(): BelongsTo
    {
        return $this->belongsTo(JobTitle::class);
    }

    public function userNotes(): HasMany
    {
        return $this->hasMany(UserNote::class);
    }
}
