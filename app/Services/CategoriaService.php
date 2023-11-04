<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Cuenta; 
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Modalidad;
use App\Models\TipoCuenta;

/**
 * Class CategoriaService.
 */
class CategoriaService
{
    protected $categoriaService;

    public function __construct()
    {
        
    }
    public function crearCategoria(){
        try{

        
          
        }catch (Exception $e) {
            Log::error($e->getMessage());

            return $e->getMessage();
        }
    }
    public function categoriasIndex(){
        try{  
            $usuarioAutenticado = Auth::user();
            $categoriasUsuario = $usuarioAutenticado->categorias;

            return $categoriasUsuario;
            
         }catch (Exception $e) {
            Log::error($e->getMessage());

            return $e->getMessage();
        }
       
    }
}
