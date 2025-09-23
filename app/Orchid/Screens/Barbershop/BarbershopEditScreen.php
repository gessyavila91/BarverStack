<?php

namespace App\Orchid\Screens\Barbershop;

use App\Domain\Barbershop\Entities\Barbershop;
use App\Domain\Barbershop\Rules\UniqueBarbershopName;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BarbershopEditScreen extends Screen
{
    public $barbershop;

    public function query(Barbershop $barbershop): iterable
    {
        return ['barbershop' => $barbershop];
    }

    public function name(): ?string
    {
        return $this->barbershop->exists ? 'Edit Barbershop' : 'Create Barbershop';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Save')->icon('bs.check-circle')->method('save'),
            Button::make('Remove')
                ->icon('bs.trash')
                ->method('remove')
                ->canSee($this->barbershop->exists),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('barbershop.name')
                    ->title('Name')
                    ->required(),
                Input::make('barbershop.address')
                    ->title('Address')
                    ->required(),
            ]),
        ];
    }

    public function save(Barbershop $barbershop, Request $request)
    {
        $data = $request->validate([
            'barbershop.name' => ['required', 'string', new UniqueBarbershopName($barbershop->id)],
            'barbershop.address' => ['required', 'string'],
        ]);

        $barbershop->fill($data['barbershop'])->save();

        Toast::info('Barbershop was saved.');

        return redirect()->route('platform.barbershops');
    }

    public function remove(Barbershop $barbershop)
    {
        $barbershop->delete();

        Toast::info('Barbershop was deleted.');

        return redirect()->route('platform.barbershops');
    }
}
