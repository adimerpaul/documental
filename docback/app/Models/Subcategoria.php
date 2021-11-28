<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'nombre',
        'sigla',
        'fecha',
        'categoria_id'
    ];
}
