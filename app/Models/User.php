<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    const CREATED_AT = 'U_CreateDate';
    const UPDATED_AT = 'U_UpdateDate';
    public $incrementing = false;
    protected $table = 'OUSR_H';
    protected $primaryKey = 'U_UserID';
    protected $rememberTokenName = 'U_RememberToken';

    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'U_Password', 'U_CreateDate', 'U_UpdateDate'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'U_CreateDate' => 'datetime',
        'U_UpdateDate' => 'datetime',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->U_Password;
    }

    /**
     * set user's updated at
     *
     * @param $value
     * @throws \Exception
     */
    public function setUUpdateDateAttribute($value)
    {
        $this->attributes['U_UpdateDate'] = (new Carbon(substr($value, 0, 18)))->format('Y-m-d H-i-s');
    }

    /**
     * set user's created at
     *
     * @param $value
     * @throws \Exception
     */
    public function setUCreateDateAttribute($value)
    {
        $this->attributes['U_CreateDate'] = (new Carbon(substr($value, 0, 18)))->format('Y-m-d H-i-s');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
