<?php

namespace App\Http\Controllers;

use App\Models\Barbershop;
use Illuminate\Http\Request;

class BarbershopController extends Controller
{
    public function index()
    {
        return response()->json(Barbershop::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
        ]);

        $barbershop = Barbershop::create($data);

        return response()->json($barbershop, 201);
    }

    public function show(Barbershop $barbershop)
    {
        return response()->json($barbershop);
    }

    public function update(Request $request, Barbershop $barbershop)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
        ]);

        $barbershop->update($data);

        return response()->json($barbershop);
    }

    public function destroy(Barbershop $barbershop)
    {
        $barbershop->delete();

        return response()->json(null, 204);
    }
}
