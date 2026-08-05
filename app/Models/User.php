<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [

        'name',

        'email',

        'password',

        'telegram_id',

        'telegram_username',

        'first_name',

        'last_name',

        'referral_code',

        'referred_by_user_id',

        'status',

        'telegram_joined_at',

        'last_bot_message_id',

        'is_admin',

        'level_id',

        'activation_deposit_id',

        'professional_activated_at',

        'withdraw_unlocked_at',

    ];

    protected function casts(): array
    {
        return [

            'telegram_joined_at' => 'datetime',

            'professional_activated_at' => 'datetime',

            'withdraw_unlocked_at' => 'datetime',

            'email_verified_at' => 'datetime',

            'password' => 'hashed',

            'is_admin' => 'boolean',

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function activationDeposit(): BelongsTo
    {
        return $this->belongsTo(
            Deposit::class,
            'activation_deposit_id'
        );
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(
            self::class,
            'referred_by_user_id'
        );
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(
            self::class,
            'referred_by_user_id'
        );
    }

    public function referralRecords(): HasMany
    {
        return $this->hasMany(
            Referral::class,
            'referrer_id'
        );
    }

    public function referredRecord(): HasOne
    {
        return $this->hasOne(
            Referral::class,
            'referred_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isProfessional(): bool
    {
        return $this->professional_activated_at !== null;
    }

    public function canWithdraw(): bool
    {
        return $this->withdraw_unlocked_at !== null;
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /*
    |--------------------------------------------------------------------------
    | Filament
    |--------------------------------------------------------------------------
    */

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }
}
