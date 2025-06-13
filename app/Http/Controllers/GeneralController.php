<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGeneralRequest;
use App\Http\Requests\UpdateGeneralRequest;
use App\Models\General;
use Illuminate\Http\Request;


class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //llames a los registros para mostrarlos en tabla
        
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //El formjulario para crear
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeneralRequest $request)
    {
        //este es el proceso que crea
    }

    /**
     * Display the specified resource.
     */
    public function show(General $general)
    {
        //este es el que muestra
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(General $general)
    {
        //El que muestra el form para editar
        //return "mostrar el unico registro";
    
        $general = General::find(1);

        // if (!$general) {
        //     return redirect()->back()->with('error', 'El registro no existe');
        // }

        
        return view('pages.general.edit', compact('general'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
            
            $general = General::findOrfail($id); 

            if ($request->hasFile("imagenmailing")) {
                $file = $request->file('imagenmailing');
                $routeImg = 'mail/';
                $nombreImagen = 'fondo.png';
          
                $this->saveImg($file, $routeImg, $nombreImagen);
            } 

            // Actualizar los campos del registro con los datos del formulario
            $general->update($request->all());

            // Guardar 
            $general->save();  

            return back()->with('success', 'Registro actualizado correctamente');

    }


    public function saveImg($file, $route, $nombreImagen)
    {
      $manager = new ImageManager(new Driver());
      $img =  $manager->read($file);
      // $img->coverDown(1000, 1500, 'center');
  
      if (!file_exists($route)) {
        mkdir($route, 0777, true);
      }

      if (file_exists($route.$nombreImagen)) {
        unlink($route.$nombreImagen);
        }
  
      $img->save($route.$nombreImagen);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(General $general)
    {
        //Este es el proceso que borra
    }
}
