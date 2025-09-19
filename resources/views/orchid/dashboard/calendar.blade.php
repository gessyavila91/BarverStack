@php
    use Illuminate\Support\Collection;

    /** @var Collection|\App\Domain\Appointment\Entities\Appointment[] $appointments */
    $calendarEvents = collect($appointments ?? [])
        ->filter(static fn ($appointment) => !empty($appointment->starts_at))
        ->map(static function ($appointment) {
            $start = optional($appointment->starts_at)->toIso8601String();
            $end = optional($appointment->ends_at)->toIso8601String() ?: $start;

            $clientName = optional($appointment->client)->name;
            $barberName = optional($appointment->barber)->name;
            $serviceName = optional($appointment->service)->name;
            $barbershopName = optional($appointment->barbershop)->name;

            return [
                'id' => $appointment->id,
                'title' => trim(($clientName ?? __('Cita')) . ($serviceName ? " · {$serviceName}" : '')),
                'start' => $start,
                'end' => $end,
                'allDay' => false,
                'extendedProps' => [
                    'clientName' => $clientName,
                    'barberName' => $barberName,
                    'serviceName' => $serviceName,
                    'barbershopName' => $barbershopName,
                    'notes' => $appointment->notes,
                    'barberId' => optional($appointment->barber)->id,
                    'barbershopId' => optional($appointment->barbershop)->id,
                    'startsAt' => optional($appointment->starts_at)->toDayDateTimeString(),
                    'endsAt' => optional($appointment->ends_at)->toDayDateTimeString(),
                ],
            ];
        })
        ->values();
@endphp

<div class="grid gap-4">
    <div class="bg-white dark:bg-gray-900 rounded shadow-sm p-4">
        <div class="flex flex-col md:flex-row md:items-end gap-4">
            <div class="w-full md:w-1/3">
                <label for="filter-barber" class="form-label">{{ __('Barbero') }}</label>
                <select id="filter-barber" class="form-control">
                    <option value="">{{ __('Todos los barberos') }}</option>
                    @foreach(($barbers ?? collect()) as $barber)
                        <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-1/3">
                <label for="filter-barbershop" class="form-label">{{ __('Barbería') }}</label>
                <select id="filter-barbershop" class="form-control">
                    <option value="">{{ __('Todas las barberías') }}</option>
                    @foreach(($barbershops ?? collect()) as $barbershop)
                        <option value="{{ $barbershop->id }}">{{ $barbershop->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-1/3 md:ml-auto text-sm text-slate-500 dark:text-slate-300">
                <p class="mb-1 font-semibold">{{ __('Consejos de uso') }}</p>
                <p class="mb-0">{{ __('Filtra por barbero o barbería para resaltar las citas correspondientes en el calendario.') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded shadow-sm p-2 md:p-4">
        <div id="appointment-calendar"
             data-events='@json($calendarEvents, JSON_UNESCAPED_UNICODE)'
             class="min-h-[650px]"></div>
    </div>
</div>

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" integrity="sha384-uQG+J9H3BHQYaWV7k/akdUSHh3DquynjUTduVdJN9WewtGJwFFnsp77livZYjM4V" crossorigin="anonymous">
    <style>
        #appointment-calendar {
            min-height: 650px;
        }

        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 600;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js" integrity="sha384-8OhUD7qnKqRR3YKHy+pnK1vQAoYjTwCWytw4Vk6zuxITqNlrzCAlGrRhzk9koPRX" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const calendarElement = document.getElementById('appointment-calendar');
            if (!calendarElement || typeof FullCalendar === 'undefined') {
                return;
            }

            const rawEvents = (() => {
                try {
                    return JSON.parse(calendarElement.dataset.events ?? '[]');
                } catch (error) {
                    console.error('Unable to parse appointment events:', error);
                    return [];
                }
            })();

            const calendar = new FullCalendar.Calendar(calendarElement, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                },
                slotMinTime: '07:00:00',
                slotMaxTime: '22:00:00',
                expandRows: true,
                height: 'auto',
                navLinks: true,
                nowIndicator: true,
                locale: document.documentElement.lang || 'es',
                eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
                events: [],
                eventDidMount(info) {
                    const { clientName, barberName, barbershopName, serviceName, notes, startsAt, endsAt } = info.event.extendedProps ?? {};
                    const tooltipLines = [
                        startsAt && endsAt ? `${startsAt} → ${endsAt}` : startsAt,
                        clientName ? `{{ __('Cliente') }}: ${clientName}` : null,
                        barberName ? `{{ __('Barbero') }}: ${barberName}` : null,
                        barbershopName ? `{{ __('Barbería') }}: ${barbershopName}` : null,
                        serviceName ? `{{ __('Servicio') }}: ${serviceName}` : null,
                        notes ? `{{ __('Notas') }}: ${notes}` : null,
                    ].filter(Boolean);

                    if (tooltipLines.length) {
                        info.el.setAttribute('title', tooltipLines.join('\n'));
                    }
                },
            });

            const barberFilter = document.getElementById('filter-barber');
            const barbershopFilter = document.getElementById('filter-barbershop');

            const applyFilters = () => {
                const barberId = barberFilter?.value ?? '';
                const barbershopId = barbershopFilter?.value ?? '';

                const filteredEvents = rawEvents.filter((event) => {
                    const eventBarberId = String(event.extendedProps?.barberId ?? '');
                    const eventBarbershopId = String(event.extendedProps?.barbershopId ?? '');

                    const matchBarber = !barberId || eventBarberId === barberId;
                    const matchBarbershop = !barbershopId || eventBarbershopId === barbershopId;

                    return matchBarber && matchBarbershop;
                });

                calendar.removeAllEvents();
                calendar.addEventSource(filteredEvents);
            };

            barberFilter?.addEventListener('change', applyFilters);
            barbershopFilter?.addEventListener('change', applyFilters);

            calendar.render();
            applyFilters();
        });
    </script>
@endpush
