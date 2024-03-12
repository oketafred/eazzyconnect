<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
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

    public function totalWithdrawalAmount()
    {
        return $this->smses()->sum('cost');
    }

    public function totalDepositAmount()
    {
        return $this->sms_bundle()->where('status', SmsBundle::STATUS_SUCCESSFUL)
            ->sum('amount');
    }

    public function accountBalance()
    {
        return $this->totalDepositAmount() - $this->totalWithdrawalAmount();
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
