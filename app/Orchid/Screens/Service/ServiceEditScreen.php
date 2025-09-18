<?php

namespace App\Orchid\Screens\Service;

use App\Domain\Service\Entities\Service;
use App\Domain\Service\Rules\PositiveCost;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ServiceEditScreen extends Screen
{
    public $service;

    public function query(Service $service): iterable
    {
        return ['service' => $service];
    }

    public function name(): ?string
    {
        return $this->service->exists ? 'Edit Service' : 'Create Service';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Save')->icon('bs.check-circle')->method('save'),
            Button::make('Remove')
                ->icon('bs.trash')
                ->method('remove')
                ->canSee($this->service->exists),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('service.name')
                    ->title('Name')
                    ->required(),
                Input::make('service.cost')
                    ->title('Cost')
                    ->type('number')
                    ->step('0.01')
                    ->required(),
            ]),
        ];
    }

    public function save(Service $service, Request $request)
    {
        $data = $request->validate([
            'service.name' => ['required', 'string'],
            'service.cost' => ['required', 'numeric', new PositiveCost()],
        ]);

        $service->fill($data['service'])->save();

        Toast::info('Service was saved.');

        return redirect()->route('platform.services');
    }

    public function remove(Service $service)
    {
        $service->delete();

        Toast::info('Service was deleted.');

        return redirect()->route('platform.services');
    }
}
