<?php

namespace App\Orchid\Screens;

use App\Models\Cliente;
use Orchid\Screen\Screen;

class ClienteScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'clientes' => Cliente::paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Clientes';
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
