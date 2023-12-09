<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
        'password' => 'hashed',
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function sms_bundle(): HasMany
    {
        return $this->hasMany(SmsBundle::class);
    }

    public function smses(): HasMany
    {
        return $this->hasMany(Sms::class);
    }

    public function numberOfSentSms(): int
    {
        return $this->smses()->count();
    }

    public function numberOfPurchasedSms()
    {
        return $this->sms_bundle()->where('status', SmsBundle::STATUS_SUCCESSFUL)
            ->sum('number_of_sms');
    }

    public function smsCredit()
    {
        return $this->numberOfPurchasedSms() - $this->numberOfSentSms();
    }

    public function successfulSmsCount(): int
    {
        return $this->smses()
            ->where('status', 'Success')
            ->count();
    }

    public function failedSmsCount(): int
    {
        return $this->smses()
            ->where('status', '!=', 'Success')
            ->count();
    }
}
