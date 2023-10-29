<?php

namespace App\Http\Controllers;

use App\Models\Subcategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;
use \Illuminate\Support\Facades\DB;


class SubcategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategorias = Subcategoria::select('subcategorias.id','subcategorias.nombre','categoria_id','categorias.nombre as categoria')
        ->join('categorias','categorias.id', '=', 'subcategorias.categoria_id')
        ->paginate(10);

        $categorias = Categoria::all();
        return Inertia::render('Subcategorias/Index', ['subcategorias'=>$subcategorias, 'categorias'=>$categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=> 'required',
            'categoria_id'=>'required'
        ]);
        $subcategoria = new Subcategoria($request->input());
        $subcategoria->save();
        return redirect('subcategorias');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategoria $subcategoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategoria $subcategoria)
    {
        return Inertia::render('Subcategorias/Edit',['subcategoria'=>$subcategoria]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategoria $subcategoria)
    {
        $request->validate([
            'nombre'=> 'required|max',
            'categoria_id'=>'required'
        ]);
        $subcategoria->update($request->input());
        return redirect('subcategorias');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategoria $subcategoria)
    {
        $subcategoria->delete();
        return redirect('subcategorias');
    }
    public function SubcategoriasPorCategoria(){
        $data = Subcategoria::select(DB::raw('count(subcategorias.id) as count, categorias.nombre'))
        ->join('categorias','categorias.id', '=', 'subcategorias.categoria_id')
        ->groupBy('categorias.nombre')->get();
        return Inertia::render('Subcategorias/Graficos', ['data'=>$data]);
    }
    public function informes(){
        $subcategorias = Subcategoria::select('subcategorias.id','subcategorias.nombre','categoria_id','categorias.nombre as categoria')
        ->join('categorias','categorias.id', '=', 'subcategorias.categoria_id')
        ->get();

        $categorias = Categoria::all();
        return Inertia::render('Subcategorias/Informes', ['subcategorias'=>$subcategorias, 'categorias'=>$categorias]);
    }
}
