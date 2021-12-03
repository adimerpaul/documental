<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;
    protected $fillable=[
        "fechaprestamo",
        "fechadevolucion",
        "observacion",
        "estado",
        'user_id',
        'documento_id',
    ];
    function user(){
        return $this->belongsTo(User::class);
    }
    function documento(){
        return $this->belongsTo(Documento::class)->with('categoria')->with('subcategoria');
    }
}
