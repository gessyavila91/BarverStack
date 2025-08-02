<?php

namespace App\Orchid\Screens;

use App\Models\Barberia;
use Orchid\Screen\Screen;

class BarberiaScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'barberias' => Barberia::paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Barberias';
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
