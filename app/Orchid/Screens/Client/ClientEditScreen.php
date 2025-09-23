<?php

namespace App\Orchid\Screens\Client;

use App\Domain\Client\Entities\Client;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ClientEditScreen extends Screen
{
    public $client;

    public function query(Client $client): iterable
    {
        return ['client' => $client];
    }

    public function name(): ?string
    {
        return $this->client->exists ? 'Edit Client' : 'Create Client';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Save')->icon('bs.check-circle')->method('save'),
            Button::make('Remove')
                ->icon('bs.trash')
                ->method('remove')
                ->canSee($this->client->exists),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('client.name')
                    ->title('Name')
                    ->required(),
                Input::make('client.phone')
                    ->title('Phone')
                    ->mask([
                        'mask' => [
                            '+99 999 999 9999',
                            '(999) 999-9999',
                        ],
                        'greedy' => false,
                        'removeMaskOnSubmit' => true,
                    ]),
                Input::make('client.email')
                    ->title('Email'),
                DateTimer::make('client.birthday')
                    ->title('Birthday')
                    ->format('Y-m-d')
                    ->allowInput(),
                Input::make('client.occupation')
                    ->title('Occupation'),
            ]),
        ];
    }

    public function save(Client $client, Request $request)
    {
        $data = $request->validate([
            'client.name' => ['required', 'string'],
            'client.phone' => ['nullable', 'string'],
            'client.email' => ['nullable', 'email'],
            'client.birthday' => ['nullable', 'date'],
            'client.occupation' => ['nullable', 'string'],
        ]);

        $client->fill($data['client'])->save();

        Toast::info('Client was saved.');

        return redirect()->route('platform.clients');
    }

    public function remove(Client $client)
    {
        $client->delete();

        Toast::info('Client was deleted.');

        return redirect()->route('platform.clients');
    }
}
