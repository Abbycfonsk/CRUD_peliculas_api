<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;
    protected $table='peliculas';
    public $timestamps=false;

    protected $fillable=[
        'titulo',
        'direccion',
        'anio',
        'sinopsis',
        'img',
        'original',
        'idcategoria',
        
    ];
    public static function consulta($filtro=null,$idcategoria=null){
        if ($idcategoria){
            return Pelicula::where('titulo','like',"%$filtro%")->where('idcategoria',$idcategoria)->orderBy('titulo')->get();
        }else{
            return Pelicula::where('titulo','like',"%$filtro%")->orderBy('titulo')->get();
        }
    }
    public static function alta($datos){
     
        $pelicula=Pelicula::create([
            'titulo'=>$datos['titulo'],
            'direccion'=>$datos['direccion'],
            'anio'=>$datos['anio'],
            'sinopsis'=>$datos['sinopsis'],
            'img'=>$datos['portada'],
            'original'=>'N',
            'idcategoria'=>$datos['idcategoria'],
            
        ]);
        return $pelicula;
    }
    
}


