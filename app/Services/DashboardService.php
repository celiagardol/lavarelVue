<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Cuenta; 
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Modalidad;
use App\Models\Movimiento;
use Illuminate\Support\Carbon;
use \Illuminate\Support\Facades\DB;

/**
 * Class DashboardService.
 */
class DashboardService
{
    protected $dashboardService;

    public function __construct()
    {
        
    }
    public function obtenerCuentasConSaldo($usuarioAutenticado){
        try{
            $cuentasConSaldo = $usuarioAutenticado->cuentas->map(function ($cuenta) {
                return [
                    'nombre' => $cuenta->nombre,
                    'saldo' => $cuenta->saldoActual,
                ];
            });
            return $cuentasConSaldo;
        }catch (Exception $e) {
            Log::error($e->getMessage());

            return $e->getMessage();
        }
    }

    public function obtenerMovimientos($usuarioAutenticado){
        try{
            $movimientos = collect(); // Inicializamos una colección para almacenar los movimientos

            // Calcular la fecha de hoy
            $hoy = Carbon::now();
            $cuentasDelUsuario = $usuarioAutenticado->cuentas; 
    
            foreach ($cuentasDelUsuario as $cuenta) {
                $movimientosDeCuenta = Movimiento::where('estado_movimiento_id', 1)
                    ->where('fecha', '>', $hoy) 
                    ->where('cuenta_id', $cuenta->id)
                    ->orderBy('fecha', 'asc') 
                    ->take(4)
                    ->select('concepto', 'importe', 'fecha')
                    ->get();
                $movimientos = $movimientos->concat($movimientosDeCuenta);
            }
            return $movimientos;
        }catch (Exception $e) {
            Log::error($e->getMessage());

            return $e->getMessage();
        }
    }

    public function obtenerGastosPorCategoria($usuarioAutenticado){
        try{

            $gastosPorCategoria = DB::table('categorias')
            ->select('categorias.nombre', DB::raw('COALESCE(SUM(movimientos.importe), 0) as total'))
            ->leftJoin('movimientos', function($join) use ($usuarioAutenticado) {
                $join->on('categorias.id', '=', 'movimientos.categoria_id')
                    ->where('movimientos.user_id', $usuarioAutenticado->id)
                    ->whereYear('movimientos.fecha', Carbon::now()->year)
                    ->whereMonth('movimientos.fecha', Carbon::now()->month);
            })
            ->groupBy('categorias.nombre')
            ->orderByRaw('total = 0')
            ->orderBy('total', 'desc') 
            ->get();

        return $gastosPorCategoria;

        }catch (Exception $e) {
            Log::error($e->getMessage());

            return $e->getMessage();
        }
    }
}
