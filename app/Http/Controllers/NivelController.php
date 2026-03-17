<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use App\Models\Curso;
use App\Models\Alumno;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    public function index(Request $request)
    {
        $query = Nivel::query();

        if ($request->search) {
            $query->where('nombre','like','%'.$request->search.'%');
        }

        $niveles = $query->orderBy('id','desc')
            ->paginate(10);

        return view('academica.niveles.index', compact('niveles'));
    }

    public function create()
    {
        return view('academica.niveles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:niveles,nombre'
        ]);

        Nivel::create([
            'nombre' => $request->nombre,
            'activo' => true
        ]);

        return redirect()
            ->route('academica.niveles.index')
            ->with('success','Nivel creado correctamente.');
    }

    public function edit(Nivel $nivel)
    {
        return view('academica.niveles.edit', compact('nivel'));
    }

    public function update(Request $request, Nivel $nivel)
    {
        $request->validate([
            'nombre' => 'required|unique:niveles,nombre,' . $nivel->id
        ]);

        $nivel->update([
            'nombre' => $request->nombre,
            'activo' => $request->has('activo')
        ]);

        return redirect()
            ->route('academica.niveles.index')
            ->with('success','Nivel actualizado correctamente.');
    }

    public function destroy(Nivel $nivel)
    {
        $nivel->activo = !$nivel->activo;
        $nivel->save();

        Curso::where('nivel_id',$nivel->id)
            ->update([
                'activo' => $nivel->activo
            ]);

        Alumno::whereIn('curso_id', function($query) use ($nivel){
            $query->select('id')
                ->from('cursos')
                ->where('nivel_id', $nivel->id);
        })->update([
            'activo' => $nivel->activo
        ]);

        return redirect()
            ->route('academica.niveles.index')
            ->with('success','Estado del nivel actualizado correctamente.');
    }
}