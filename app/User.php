<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // se usa para utilizar los archivos de vendor de spaty


class User extends Authenticatable
{
    
    use Notifiable,HasRoles ;
    // para usar los roles con el spaty 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','genero','city_id','telefono',
        'domicilio','fecha_n','cedula','edad'
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


    public function posts (){
        return $this->hasMany('App\Post');
    }

    public function city (){
        return $this->belongsTo('App\City');
    }
}
