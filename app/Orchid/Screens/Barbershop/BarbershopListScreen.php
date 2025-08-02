<?php

namespace App\Orchid\Screens\Barbershop;

use App\Domain\Barbershop\Entities\Barbershop;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;

class BarbershopListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'barbershops' => Barbershop::paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Barbershops';
    }

    public function layout(): iterable
    {
        return [
            Layout::table('barbershops', [
                TD::make('id'),
                TD::make('name'),
                TD::make('address'),
            ]),
        ];
    }
}
