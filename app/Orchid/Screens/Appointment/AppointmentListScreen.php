<?php

namespace App\Orchid\Screens\Appointment;

use App\Domain\Appointment\Entities\Appointment;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class AppointmentListScreen extends Screen
{
    public string $permission = 'platform.appointments';

    public function query(): iterable
    {
        return [
            'appointments' => Appointment::query()
                ->with(['client', 'barber', 'barbershop'])
                ->latest('starts_at')
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Appointments';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Schedule appointment')
                ->icon('bs.plus')
                ->route('platform.appointments.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('appointments', [
                TD::make('starts_at', 'Start')
                    ->render(fn (Appointment $appointment) => $appointment->starts_at?->format('Y-m-d H:i')),
                TD::make('ends_at', 'End')
                    ->render(fn (Appointment $appointment) => $appointment->ends_at?->format('Y-m-d H:i')),
                TD::make('client.name', 'Client')
                    ->render(fn (Appointment $appointment) => Link::make(optional($appointment->client)->name ?? 'View')
                        ->route('platform.appointments.edit', $appointment)),
                TD::make('barber.name', 'Barber')
                    ->render(fn (Appointment $appointment) => optional($appointment->barber)->name ?? '—'),
                TD::make('barbershop.name', 'Location')
                    ->render(fn (Appointment $appointment) => optional($appointment->barbershop)->name ?? '—'),
            ]),
        ];
    }
}
