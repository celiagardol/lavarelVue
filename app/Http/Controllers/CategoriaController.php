<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarioAutenticado = Auth::user();
        $categoriasUsuario = $usuarioAutenticado->categorias;
        //$categorias = Categoria::all();
        return Inertia::render('Categorias/Index',['categorias'=>$categoriasUsuario]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Categorias/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
      //  $request->validate(['name'=>'required']);
      $usuarioAutenticado = Auth::user();

        $categoria = new Categoria($request->input());
        $categoria->user_id = $usuarioAutenticado->id;
        $categoria->save();
        return redirect('categorias');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {

        return Inertia::render('Categorias/Edit',['categoria'=>$categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
      //  $request->validate(['name'=>'required|max:100']);
        $categoria->update($request->all());
        return redirect('categorias');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect('categorias');
    }
}
