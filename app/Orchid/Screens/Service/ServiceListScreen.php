<?php

namespace App\Orchid\Screens\Service;

use App\Domain\Service\Entities\Service;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

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

    public function commandBar(): iterable
    {
        return [
            Link::make('Create')
                ->icon('bs.plus')
                ->route('platform.services.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('services', [
                TD::make('id'),
                TD::make('name')
                    ->render(fn (Service $service) => Link::make($service->name)
                        ->route('platform.services.edit', $service)),
                TD::make('cost'),
            ]),
        ];
    }
}
