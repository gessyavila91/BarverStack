<?php

namespace App\Orchid\Screens\Client;

use App\Domain\Client\Entities\Client;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;

class ClientListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'clients' => Client::paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Clients';
    }

    public function layout(): iterable
    {
        return [
            Layout::table('clients', [
                TD::make('id'),
                TD::make('name'),
                TD::make('email'),
            ]),
        ];
    }
}
