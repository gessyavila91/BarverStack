<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Barbershop\Entities\Barbershop;
use App\Models\User;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $appointments = Appointment::query()
            ->with(['client', 'barber', 'service', 'barbershop'])
            ->orderBy('starts_at')
            ->get();

        return [
            'appointments' => $appointments,
            'barbers' => User::query()
                ->select(['id', 'name'])
                ->barbers()
                ->orderBy('name')
                ->get(),
            'barbershops' => Barbershop::query()
                ->select(['id', 'name'])
                ->orderBy('name')
                ->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Dashboard';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Centraliza tu agenda de barbería.';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::view('orchid.dashboard.calendar'),
        ];
    }
}
