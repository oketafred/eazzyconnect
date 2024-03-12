<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsBundle extends Model
{
    use HasFactory;

    public const SMS_UNIT_PRICE = 30;

    public const STATUS_PENDING = 'pending';

    public const STATUS_SUCCESSFUL = 'success';

    public const STATUS_FAILED = 'failed';

    public const STATUS_ERROR = 'error';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_FAILED_FROM_SYSTEM = 'failed_from_system';

    public const FAILED_FROM_SYSTEM_MESSAGE = 'Transaction process incomplete';

    protected $fillable = [
        'user_id',
        'currency_code',
        'amount',
        'transaction_reference',
        'external_id',
        'customer_name',
        'customer_email',
        'phone_number',
        'transaction_fee',
        'transaction_percent',
        'additional_fee',
        'additional_percent',
        'status',
        'payment_type',
        'checked_at',
        'failure_reason',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new UserScope());
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
