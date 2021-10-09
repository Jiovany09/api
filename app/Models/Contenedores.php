<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Generadores;

class Contenedores extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','contenedor','estado','empleado_id','generador_id','serial','contador'
    ];

    protected $appends = ['numlamparas'];

    public function empleados(){
        return $this->hasOne(User::class,'id','empleado_id');
    }

    public function generadores(){
        return $this->hasOne(Generadores::class,'id','generador_id');
    }

    public function getNumlamparasAttribute(){
        return $this->lamparas()->count();
    }
    public function lamparas(){
        return$this->hasMany(Lamparas::class,'contenedor_id','id');
    }
}
