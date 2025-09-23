<?php

namespace App\Orchid\Screens\Barbershop;

use App\Domain\Barbershop\Entities\Barbershop;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

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

    public function commandBar(): iterable
    {
        return [
            Link::make('Create')
                ->icon('bs.plus')
                ->route('platform.barbershops.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('barbershops', [
                TD::make('id'),
                TD::make('name')
                    ->render(fn (Barbershop $barbershop) => Link::make($barbershop->name)
                        ->route('platform.barbershops.edit', $barbershop)),
                TD::make('address'),
            ]),
        ];
    }
}
