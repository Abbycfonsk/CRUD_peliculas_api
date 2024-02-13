<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table='categorias';
    public $timestamps=null;
    protected $fillable=[
        'nombre',
    ];

    public static function consulta(){
        return Categoria::orderBy('nombre')->get();
    }
}
