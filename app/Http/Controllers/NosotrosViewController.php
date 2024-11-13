<?php

namespace App\Http\Controllers;

use App\Models\NosotrosView;
use App\Http\Requests\StoreNosotrosViewRequest;
use App\Http\Requests\UpdateNosotrosViewRequest;
use App\Models\General;
use Illuminate\Http\Request;

class NosotrosViewController extends Controller
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
    public function store(StoreNosotrosViewRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NosotrosView $nosotrosView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NosotrosView $nosotrosView)
    {   
        $nosotros = NosotrosView::first();
        if (!$nosotros) {
            $nosotros = NosotrosView::create();
        }
        return view('pages.nosotrosview.edit', compact('nosotros'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $nosotros = NosotrosView::findOrfail($id); 

        $nosotros->update($request->all());

        $nosotros->save();  

        return back()->with('success', 'Registro actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NosotrosView $nosotrosView)
    {
        //
    }
}
