<?php

namespace App\Orchid\Screens;

use App\Domain\Barbershop\Entities\Barbershop;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;

class BarbershopScreen extends Screen
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

    public function commandBar(): iterable
    {
        return [
            Link::make('Create Barbershop')
                ->icon('plus')
                ->route('platform.barbershops.create'),
        ];
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
