<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contenedores;

class Lamparas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','lampara','estado','contenedor_id'
    ];

    public function contenedores(){
        return $this->hasOne(Contenedores::class,'id','contenedor_id');
    }
}
