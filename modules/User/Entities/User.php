<?php

namespace Modules\User\Entities;

use Fndmiranda\SimpleAddress\Entities\Address;
use Fndmiranda\SimpleAddress\Pivot\AddressPivot;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Modules\Account\Notifications\ResetPassword;
use Modules\Balance\Entities\Balance;
use Modules\Bank\Entities\Bank;
use Modules\Bank\Pivot\BankPivot;
use Modules\Core\Scopes\OrderSortRequestScope;
use Modules\Phone\Entities\Phone;
use Modules\Place\Entities\Place;
use Modules\Place\Pivot\PlacePivot;
use Modules\Transaction\Entities\Transaction;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_users';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['first_name', 'avatar'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'nickname', 'password', 'pin', 'birthdate', 'document_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'pin', 'remember_token',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderSortRequestScope);
    }

    /**
     * Get the user's first_name.
     *
     * @return string
     */
    public function getFirstNameAttribute()
    {
        return current(explode(' ', $this->name));
    }

    /**
     * Get the user's full name.
     *
     * @return array
     */
    public function getAvatarAttribute()
    {
        return [
            'xs' => 'https://www.gravatar.com/avatar/' . md5($this->email) . '?s=80&d=mm',
            'sm' => 'https://www.gravatar.com/avatar/' . md5($this->email) . '?s=120&d=mm',
            'md' => 'https://www.gravatar.com/avatar/' . md5($this->email) . '?s=240&d=mm',
            'lg' => 'https://www.gravatar.com/avatar/' . md5($this->email) . '?s=480&d=mm',
            'xl' => 'https://www.gravatar.com/avatar/' . md5($this->email) . '?s=1024&d=mm',
        ];
    }

    /**
     * Send the password reset notification.
     * @note: This override Authenticatable methodology to Api.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Hash the password given.
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        if (Hash::needsRehash($password)) {
            $password = Hash::make($password);
        }

        $this->attributes['password'] = $password;
    }

    /**
     * Hash the pin given.
     *
     * @param string $pin
     */
    public function setPinAttribute($pin)
    {
        if (Hash::needsRehash($pin)) {
            $pin = Hash::make($pin);
        }

        $this->attributes['pin'] = $pin;
    }

}
