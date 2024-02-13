<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Pelicula;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PeliculasController extends Controller
{
    public function consulta(){
        $datos=request()->all();
        $peliculas=Pelicula::all();
        $peliculas=Pelicula::consulta($datos['filtro'] ?? null, $datos['idcategoria'] ?? null);
        return response()->json($peliculas,200);
    }
    public function detalle($id){
        $pelicula=Pelicula::find($id);
        if (!$pelicula){
            return response()->json(['pelicula no existe'],404);
        }
        $pelicula->categoria=Categoria::find($pelicula->idcategoria)->nombre;
        return response()->json($pelicula,200);
    }
    public function alta (Request $request){
        $datos=$request->all();
        $imagen=$request->file('portada');
        $rules=array(
            'titulo'=>'required|unique:peliculas,titulo',
            'direccion'=>'required',
            'anio'=>'required|numeric|min:1900|max:2100',
            'sinopsis'=>'required',
            'portada'=>'image|mimes:jpg,jpeg,png|max:300',
            'idcategoria'=>'required'
        );
      
        $validator=Validator::make($datos,$rules,[
            'titulo.required'=>'Título es obligatorio',
            'titulo.unique'=>'Este título ya pertenece a otra película',
            'direccion.required'=>'Dirección es obligatorio',
            'anio.required'=>'Año es obligatorio',
            'anio.numeric'=>'Año debe ser númerico',
            'anio.min'=>'Año debe ser superior a 1900',
            'anio.max'=>'Año debe ser inferior a 2100',
            'sinopsis.required'=>'Sinopsis es obligatoria',
            'idcategoria'=>'Categoría es obligatoria'
        ]);
        if ($validator->fails()){
            $errores=$validator->getMessageBag()->all();
            return response()->json($errores,400);  
        }
       
        if($imagen){
            $nombreArchivo=$imagen->getClientOriginalName();
            Storage::putFileAs("",$imagen,$nombreArchivo);
            $datos['portada']=$nombreArchivo;
          }else{
              $datos['portada']='sinportada.jpg';
          }
          $pelicula=Pelicula::alta($datos);
          $datos['categorias']=Categoria::consulta();
          $datos['mensaje']='Alta de película efectuada';
          return response()->json($pelicula,201);

    }
    public function modificacion(Request $request, Pelicula $pelicula){
        if(!$pelicula){
            return response()->json(['pelicula no existe'],404);
        }
        $datos=$request->all();
        $imagen=$request->file('portada');
        $rules=array(
            'titulo'=>'required|unique:peliculas,titulo',
            'direccion'=>'required',
            'anio'=>'required|numeric|min:1900|max:2100',
            'sinopsis'=>'required',
            'portada'=>'image|mimes:jpg,jpeg,png|max:300',
            'idcategoria'=>'required'
        );
      
        $validator=Validator::make($datos,$rules,[
            'titulo.required'=>'Título es obligatorio',
            'titulo.unique'=>'Este título ya pertenece a otra película',
            'direccion.required'=>'Dirección es obligatorio',
            'anio.required'=>'Año es obligatorio',
            'anio.numeric'=>'Año debe ser númerico',
            'anio.min'=>'Año debe ser superior a 1900',
            'anio.max'=>'Año debe ser inferior a 2100',
            'sinopsis.required'=>'Sinopsis es obligatoria',
            'idcategoria'=>'Categoría es obligatoria'
        ]);
        if ($validator->fails()){
            $errores=$validator->getMessageBag()->all();
            return response()->json($errores,400);  
        }
        if($imagen){
            $nombreArchivo=$imagen->getClientOriginalName();
            Storage::putFileAs("",$imagen,$nombreArchivo);
            $datos['portada']=$nombreArchivo;
            $pelicula['img']=$datos['portada'];
            
        }else{
              $datos['portada']='sinportada.jpg';
        }
        $pelicula->update($datos);
        return response()->json($pelicula,200);
    }
    public function baja(Pelicula $pelicula){
        if(!$pelicula){
            return response()->json(['pelicula no existe'],404);
        }
        $deleted=$pelicula->delete();
        if($deleted && $pelicula->img != 'sinportada.jpg'){
            unlink(public_path("img/$pelicula->img"));
        }
        return response()->json([],200);

    }
}
