<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new UserScope());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
