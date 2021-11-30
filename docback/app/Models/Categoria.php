<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'nombre',
        'sigla',
        'fecha',
    ];

    public function subcategorias(){
        return $this->hasMany(Subcategoria::class);

    }
}
