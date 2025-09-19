<?php

namespace App\Orchid\Screens\Appointment;

use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Appointment\Rules\BarberRole;
use App\Domain\Barbershop\Entities\Barbershop;
use App\Domain\Client\Entities\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AppointmentEditScreen extends Screen
{
    public Appointment $appointment;

    public string $permission = 'platform.appointments';

    public function query(Appointment $appointment): iterable
    {
        $appointment->loadMissing(['client', 'barber', 'barbershop']);

        return ['appointment' => $appointment];
    }

    public function name(): ?string
    {
        return $this->appointment->exists ? 'Edit Appointment' : 'Schedule Appointment';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Save')->icon('bs.check-circle')->method('save'),
            Button::make('Remove')
                ->icon('bs.trash')
                ->method('remove')
                ->canSee($this->appointment->exists),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Relation::make('appointment.client_id')
                    ->title('Client')
                    ->fromModel(Client::class, 'name')
                    ->required(),
                Relation::make('appointment.barber_id')
                    ->title('Barber')
                    ->fromModel(User::class, 'name')
                    ->applyScope('barbers')
                    ->required(),
                Relation::make('appointment.barbershop_id')
                    ->title('Location')
                    ->fromModel(Barbershop::class, 'name')
                    ->required(),
                DateTimer::make('appointment.starts_at')
                    ->title('Start')
                    ->enableTime()
                    ->format24hr()
                    ->required(),
                DateTimer::make('appointment.ends_at')
                    ->title('End')
                    ->enableTime()
                    ->format24hr()
                    ->required(),
                TextArea::make('appointment.notes')
                    ->title('Notes')
                    ->rows(3),
            ]),
        ];
    }

    public function save(Appointment $appointment, Request $request)
    {
        $payload = $request->input('appointment', []);

        $validated = Validator::make($payload, [
            'client_id' => ['required', 'exists:clients,id'],
            'barber_id' => ['required', 'exists:users,id', new BarberRole()],
            'barbershop_id' => ['required', 'exists:barbershops,id'],
            'starts_at' => ['required', 'date', 'after_or_equal:now'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'notes' => ['nullable', 'string'],
        ])->validate();

        $appointment->fill($validated)->save();

        Toast::info('Appointment was saved.');

        return redirect()->route('platform.appointments');
    }

    public function remove(Appointment $appointment)
    {
        $appointment->delete();

        Toast::info('Appointment was deleted.');

        return redirect()->route('platform.appointments');
    }
}
