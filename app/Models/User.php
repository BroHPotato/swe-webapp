<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId','name', 'surname', 'email', 'type', 'telegram_name', 'telegram_chat','token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getAuthIdentifierName(): string
    {
        return 'userId';
    }

    /**
     * @param string
     * @return string
     */
    public function getAuthIdentifier(): string
    {
        return $this->userId;
    }


}
