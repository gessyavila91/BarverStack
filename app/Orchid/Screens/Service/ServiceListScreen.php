<?php

namespace App\Orchid\Screens\Service;

use App\Domain\Service\Entities\Service;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;

class ServiceListScreen extends Screen
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
