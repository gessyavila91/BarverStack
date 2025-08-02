<?php

namespace App\Http\Controllers;

use App\Models\Barberia;
use Illuminate\Http\Request;

class BarberiaController extends Controller
{
    public function index()
    {
        return response()->json(Barberia::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'direccion' => 'required|string',
        ]);

        $barberia = Barberia::create($data);

        return response()->json($barberia, 201);
    }

    public function show(Barberia $barberia)
    {
        return response()->json($barberia);
    }

    public function update(Request $request, Barberia $barberia)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|required|string',
            'direccion' => 'sometimes|required|string',
        ]);

        $barberia->update($data);

        return response()->json($barberia);
    }

    public function destroy(Barberia $barberia)
    {
        $barberia->delete();

        return response()->json(null, 204);
    }
}
