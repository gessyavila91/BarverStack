<?php

namespace App\Orchid\Screens;

use App\Models\Servicio;
use Orchid\Screen\Screen;

class ServicioScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'servicios' => Servicio::paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Servicios';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [];
    }
}
