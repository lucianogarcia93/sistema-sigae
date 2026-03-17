<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Personal;
use App\Models\Sector;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Personal::with('sector');

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('dni', 'like', "%{$search}%");
            });
        }

        $personal = $query->orderBy('apellido')
                          ->paginate(10);

        return view('administrativa.personal.index', compact('personal'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $sectores = Sector::where('activo', true)
                          ->orderBy('nombre')
                          ->get();

        return view('administrativa.personal.create', compact('sectores'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'sector_id' => 'required|exists:sectores,id',
            'nombre'    => 'required|string|max:100',
            'apellido'  => 'required|string|max:100',
            'dni'       => 'required|string|max:20|unique:personal,dni',
            'cargo'     => 'required|string|max:100',
            'telefono'  => 'nullable|string|max:30',
            'email'     => 'nullable|email|max:150',
        ]);

        Personal::create($request->all());

        return redirect()
            ->route('administrativa.personal.index')
            ->with('success', 'Personal registrado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Personal $persona)
    {
        $sectores = Sector::where('activo', true)
                          ->orderBy('nombre')
                          ->get();

        return view('administrativa.personal.edit', compact('persona', 'sectores'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Personal $persona)
    {
        $request->validate([
            'sector_id' => 'required|exists:sectores,id',
            'nombre'    => 'required|string|max:100',
            'apellido'  => 'required|string|max:100',
            'dni'       => 'required|string|max:20|unique:personal,dni,' . $persona->id,
            'cargo'     => 'required|string|max:100',
            'telefono'  => 'nullable|string|max:30',
            'email'     => 'nullable|email|max:150',
        ]);

        $persona->update($request->all());

        return redirect()
            ->route('administrativa.personal.index')
            ->with('success', 'Personal actualizado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY (Toggle Activo)
    |--------------------------------------------------------------------------
    */

    public function destroy(Personal $persona)
    {
        $persona->activo = !$persona->activo;
        $persona->save();

        return redirect()
            ->route('administrativa.personal.index')
            ->with('success', 'Estado del personal actualizado correctamente.');
    }
}