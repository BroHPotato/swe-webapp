<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'userId','name', 'surname', 'email', 'type', 'telegramName', 'telegramChat', 'deleted', 'tfa', 'token'
    ];

    public function getAuthIdentifierName(): string
    {
        return 'userId';
    }

    /**
     * @param string
     * @return int
     */
    public function getAuthIdentifier()
    {
        return $this->userId;
    }

}
