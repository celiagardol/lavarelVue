<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DashboardService $dashboardService)
    {
        $usuarioAutenticado = Auth::user();

        $gastosPorCategoria =$dashboardService->obtenerGastosPorCategoria($usuarioAutenticado);
        
        $cuentasConSaldo = $dashboardService->obtenerCuentasConSaldo($usuarioAutenticado);

        $totalSaldo = $cuentasConSaldo->sum('saldo');

        $movimientos = $dashboardService->obtenerMovimientos($usuarioAutenticado);

    return Inertia::Render('Dashboard', ['gastosPorCategoria'=> $gastosPorCategoria, 'cuentasConSaldo' =>$cuentasConSaldo, 'totalSaldo' =>$totalSaldo, 'movimientos'=>$movimientos]);

    }

}
