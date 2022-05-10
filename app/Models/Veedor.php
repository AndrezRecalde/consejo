<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class Veedor extends Model
{
    use HasFactory;

    protected $table = 'veedores';

    protected $fillable = [
        'dni',
        'first_name',
        'last_name',
        'phone',
        'email',
        'observacion',
        'user_id',          //registra el ID del usuario quien lo creo.
        'parroquia_id',     //parroquia donde esta trabajando - Select Dinamico con recinto__id(doble guion)
        'recinto_id',       //recinto de donde es ORIGINARIO - Tiene UN guion bajo
        'recinto__id',      //recinto donde esta trabajando - Tiene DOBLE guion bajo - Select dinamico con parroquia
        'imagen_frontal',
        'imagen_reverso',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function create(array $attributes = [])
    {
        $attributes['user_id'] = \Auth::guard('api')->user()->id;   /** cambiar por: auth()->id() */

        $veedor = static::query()->create($attributes);

        return $veedor;
    }
    public function parroquia()
	{
		return $this->belongsTo(Parroquia::class,'parroquia_id','id');
	}
    public function recinto()
	{
		return $this->belongsTo(Recinto::class,'recinto_id','id');
	}
    public function trabajo()
	{
		return $this->belongsTo(Recinto::class,'recinto__id','id');
	}
}
