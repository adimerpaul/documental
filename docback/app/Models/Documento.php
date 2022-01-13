<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $fillable = [
        'cod',
        'fondo',
        'archivo',
        'gestion',
        'tomo',
        'numtotal',
        'detalle',
        'estado',
        'fecha',
        'categoria_id',
        'subcategoria_id'
    ];

    public function subcategoria(){
        return $this->belongsTo(Subcategoria::class);

    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);

    }


}
