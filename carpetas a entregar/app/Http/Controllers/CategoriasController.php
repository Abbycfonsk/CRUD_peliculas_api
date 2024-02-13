<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoriasController extends Controller
{
    public function consulta(){
        $categorias=Categoria::consulta();
        return response()->json($categorias,200);
    }
    public function alta(){
        $datos=request()->all();
        $rules= array(
            'nombre'=>'required|unique:categorias,nombre',
        );
        $messages=array(
            'nombre.required'=>'Nombre categoría obligatorio',
            'nombre.unique'=>'Esta categoría ya existe',
        );
        $validator=Validator::make($datos,$rules,$messages);
        if ($validator->fails()){
            $errores=$validator->getMessageBag()->all();
            return response()->json($errores,400);
        }
        $categoria=Categoria::create($datos);
        return response()->json($categoria,201);
    }

    public function modificar(Categoria $categoria){
        if (!$categoria){
            return response()->json(['Categoria no existe'],404);
        }
        $datos=request()->all();
        $rules= array(
            'nombre'=>['required',Rule::unique('categorias')->ignore($categoria->id,'id')],
        );
        $messages=array(
            'nombre.required'=>'Nombre categoría obligatorio',
            'nombre.unique'=>'Esta categoría ya existe',
        );
        $validator=Validator::make($datos,$rules,$messages);
        if($validator->fails()){
            $errores=$validator->getMessageBag()->all();
            return response()->json($errores,400);
        }
        $categoria->update($datos);
        return response()->json($categoria,200);
    }

    public function baja(Categoria $categoria){
        if (!$categoria){
            return response()->json(['Categoria no existe'],404);
        }
        $deleted=$categoria->delete();
        if ($deleted){
            return response()->json([],200);
        }else{
            return response()->json(['error en la baja'],500);
        }
    }
}
