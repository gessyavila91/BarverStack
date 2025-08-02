<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'telefono' => 'nullable|string',
            'correo' => 'nullable|email',
            'fecha_de_cumpleanios' => 'nullable|date',
            'ocupacion' => 'nullable|string',
        ]);

        $cliente = Cliente::create($data);

        return response()->json($cliente, 201);
    }

    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|required|string',
            'telefono' => 'nullable|string',
            'correo' => 'nullable|email',
            'fecha_de_cumpleanios' => 'nullable|date',
            'ocupacion' => 'nullable|string',
        ]);

        $cliente->update($data);

        return response()->json($cliente);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return response()->json(null, 204);
    }
}
