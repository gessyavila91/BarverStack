<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        return response()->json(Servicio::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'costo' => 'required|numeric',
        ]);

        $servicio = Servicio::create($data);

        return response()->json($servicio, 201);
    }

    public function show(Servicio $servicio)
    {
        return response()->json($servicio);
    }

    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|required|string',
            'costo' => 'sometimes|required|numeric',
        ]);

        $servicio->update($data);

        return response()->json($servicio);
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();

        return response()->json(null, 204);
    }
}
