<?php

namespace App\Orchid\Screens;

use App\Models\Service;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;

class ServiceScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'services' => Service::paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Services';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Create Service')
                ->icon('plus')
                ->route('platform.services.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('services', [
                TD::make('id'),
                TD::make('name'),
                TD::make('cost'),
            ]),
        ];
    }
}
