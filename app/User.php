<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Firebase\JWT\JWT;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'uuid', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id','password', 'remember_token','created_at','updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Create the JWT
     *
     * @param string $id
     * @param string $userType
     *
     * @return string
     */
    public function createJWT($expire=true)
    {
        $payload = [
            'iss' => env('APP_URL'),
            'sub' => $this->id,
            'iat' => time(),
        ];

        if($expire){
              $payload['exp'] = time() + 950400; // 11 Days
        }

        return JWT::encode($payload, env('JWT_SECRET'));
    }
}
