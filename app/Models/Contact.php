<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'phone_number',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new UserScope());
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
