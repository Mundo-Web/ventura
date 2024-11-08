<?php

namespace App\Http\Controllers;

use App\Models\ExtraService;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function buscarProducto(Request $request){
       $servicios = $servicios ?? [];

       $id =  $request->id; 
       $cantidad =  (int)$request->cantidad; 
       $servicios =  $request->servicios; 

       if (is_array($servicios) && count($servicios) > 0) {
            $nombresServicios = ExtraService::whereIn('id', $servicios)->pluck('service');
        } else {
            // Si $servicios es un arreglo vacío o no válido
            $nombresServicios = collect(); // Un valor predeterminado como una colección vacía
        }

       $is_reseller = false; 
       if(Auth::check()){
        $user = Auth::user();
        $is_reseller = $user->hasRole('Reseller');
        
      }
        //busco producto 

        $producto = Products::find($id);

        return response()->json(['message' => 'Producto encontrado ', 'data' => $producto , 'servicios'=> $servicios, 'nombresServicios' => $nombresServicios, 'cantidad'=> $cantidad, 'is_reseller' => $is_reseller] );
    }
}
