<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sms extends Model
{
    use HasFactory;

    public const COST_PER_SMS = 30;
    public const MAX_NUMBER_OF_CHARACTERS_IN_AN_SMS = 160;

    protected $fillable = [
        'user_id',
        'group_id',
        'message',
        'phone_number',
        'status',
        'cost',
        'messageId',
        'failure_reason',
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
