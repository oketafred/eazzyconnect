<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
}