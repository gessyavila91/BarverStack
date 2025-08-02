<?php

namespace App\Orchid\Screens;

use App\Domain\Client\Entities\Client;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;

class ClientScreen extends Screen
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

    public function commandBar(): iterable
    {
        return [
            Link::make('Create Client')
                ->icon('plus')
                ->route('platform.clients.create'),
        ];
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
