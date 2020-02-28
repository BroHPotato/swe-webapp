<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use function foo\func;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function device(){
        $response = array(
            array(
                'nome' => 'device_1',
                'sensori' => array(
                    array(
                        'nome' => 'temp_air',
                        'dato' => rand(0,10)
                    ),
                    array(
                        'nome' => 'temp_oil',
                        'dato' => rand(0,10)
                    ),
                    array(
                        'nome' => 'utilz',
                        'dato' => rand(0,10)
                    )
                ),
            ),
            array(
                'nome' => 'device_2',
                'sensori' => array(
                    array(
                        'nome' => 'temp_air',
                        'dato' => rand(0,10)
                    ),
                    array(
                        'nome' => 'temp_oil',
                        'dato' => rand(0,10)
                    ),
                    array(
                        'nome' => 'utilz',
                        'dato' => rand(0,10)
                    )
                ),
            ),
            array(
                'nome' => 'device_3',
                'sensori' => array(
                    array(
                        'nome' => 'temp_air',
                        'dato' => rand(0,10)
                    ),
                    array(
                        'nome' => 'temp_oil',
                        'dato' => rand(0,10)
                    ),
                    array(
                        'nome' => 'utilz',
                        'dato' => rand(0,10)
                    )
                ),
            ),
        );//todo API Request here for list of device

        $devices = collect();
        foreach ($response as $tempdevice) {
            $dev = new Device();
            $dev->fill($tempdevice);
            $devices->push($dev);
        }
        return $devices;
    }
}
