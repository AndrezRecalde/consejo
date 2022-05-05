<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dni',
        'avatar',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'user_id',
        'canton_id',
        'parroquia_id',
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
    ];
    public function canton()
	{
		return $this->belongsTo(Canton::class,'canton_id','id');
	}
	public function parroquia()
	{
		return $this->belongsTo(Parroquia::class,'parroquia_id','id');
	}
    public function veedores()
    {
        return $this->hasMany(Veedor::class);
    }

    //Cuando se crea un usuario,
    //esta funcion me permite setear de manera automatica los atributos
    public static function create(array $attributes = [])
    {
        $attributes['user_id'] = \Auth::guard('api')->user()->id;   /** cambiar por: auth()->id() */
        $attributes['password'] = Hash::make('a123456');

        $user = static::query()->create($attributes);

        return $user;
    }

    //Me permite encriptar las password de los usuarios creados
    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    }

    protected static function boot()     //Si borro un usuario, se va a borrar con los veedores que ha creado
    {
        parent::boot();
        static::deleting(function($user){
            $user->veedores()->delete();
        });
    }

}
