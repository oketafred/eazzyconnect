<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SmsBundle extends Model
{
    use HasFactory;

    public const SMS_UNIT_PRICE = 30;

    public const STATUS_PENDING = 'pending';
    public const STATUS_SUCCESSFUL = 'successful';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'currency_code',
        'amount',
        'number_of_sms',
        'sms_unit_price',
        'transaction_reference',
        'external_id',
        'customer_name',
        'customer_email',
        'phone_number',
        'transaction_fee',
        'status',
        'payment_type',
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
