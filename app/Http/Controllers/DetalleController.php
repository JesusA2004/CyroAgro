<?php

namespace App\Http\Controllers;

use App\Models\Detalle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\DetalleRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $detalles = Detalle::paginate();

        return view('detalle.index', compact('detalles'))
            ->with('i', ($request->input('page', 1) - 1) * $detalles->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $detalle = new Detalle();

        return view('detalle.create', compact('detalle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetalleRequest $request): RedirectResponse
    {
        Detalle::create($request->validated());

        return Redirect::route('detalles.index')
            ->with('success', 'Detalle created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $detalle = Detalle::find($id);

        return view('detalle.show', compact('detalle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $detalle = Detalle::find($id);

        return view('detalle.edit', compact('detalle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DetalleRequest $request, Detalle $detalle): RedirectResponse
    {
        $detalle->update($request->validated());

        return Redirect::route('detalles.index')
            ->with('success', 'Detalle updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Detalle::find($id)->delete();

        return Redirect::route('detalles.index')
            ->with('success', 'Detalle deleted successfully');
    }
}
