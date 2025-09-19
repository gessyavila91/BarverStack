@php
    use Illuminate\Support\Collection;

    /** @var Collection|\App\Domain\Appointment\Entities\Appointment[] $appointments */
    $calendarEvents = collect($appointments ?? [])
        ->filter(static fn ($a) => !empty($a->starts_at))
        ->map(static function ($a) {
            $start = optional($a->starts_at)->toIso8601String();
            $end   = optional($a->ends_at)->toIso8601String() ?: $start;

            $client = optional($a->client)->name;
            $barber = optional($a->barber)->name;
            $svc    = optional($a->service)->name;
            $shop   = optional($a->barbershop)->name;

            return [
                'id'    => $a->id,
                'title' => trim(($client ?? __('Cita')) . ($svc ? " · {$svc}" : '')),
                'start' => $start,
                'end'   => $end,
                'allDay' => false,
                'extendedProps' => [
                    'clientName' => $client,
                    'barberName' => $barber,
                    'serviceName' => $svc,
                    'barbershopName' => $shop,
                    'notes' => $a->notes,
                    'barberId' => optional($a->barber)->id,
                    'barbershopId' => optional($a->barbershop)->id,
                    'startsAt' => optional($a->starts_at)->toDayDateTimeString(),
                    'endsAt' => optional($a->ends_at)->toDayDateTimeString(),
                ],
            ];
        })
        ->values();
@endphp

{{-- Contenedor vertical simple, sin grid estrecho --}}
<div class="space-y-3 w-full min-w-0">

    {{-- Barra de filtros horizontal/compacta --}}
    <div id="filters-bar" class="bg-white dark:bg-gray-900 rounded shadow-sm w-full min-w-0">
        <div class="px-3 py-2">
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2">
                    <label for="filter-barber" class="form-label mb-0 text-sm">{{ __('Barbero') }}</label>
                    <select id="filter-barber" class="form-control h-8 py-1">
                        <option value="">{{ __('Todos') }}</option>
                        @foreach(($barbers ?? collect()) as $barber)
                            <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <label for="filter-barbershop" class="form-label mb-0 text-sm">{{ __('Barbería') }}</label>
                    <select id="filter-barbershop" class="form-control h-8 py-1">
                        <option value="">{{ __('Todas') }}</option>
                        @foreach(($barbershops ?? collect()) as $barbershop)
                            <option value="{{ $barbershop->id }}">{{ $barbershop->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="ml-auto text-xs text-slate-500 dark:text-slate-300 truncate">
                    {{ __('Filtra por barbero o barbería para resaltar las citas.') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Calendario a ancho completo y altura de ventana --}}
    <div class="bg-white dark:bg-gray-900 rounded shadow-sm w-full min-w-0">
        <div id="appointment-calendar"
             data-events='@json($calendarEvents, JSON_UNESCAPED_UNICODE)'
             class="w-full min-w-0"
             style="min-height: 60vh;"></div>
    </div>
</div>

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css">
    <style>
        .fc .fc-toolbar { padding: .25rem .5rem; }
        .fc .fc-toolbar-title { font-size: 1.125rem; font-weight: 600; }
        /* Importante para que FC no se recorte en contenedores flex/grid */
        #appointment-calendar, #appointment-calendar * { min-width: 0; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        (function () {
            const readyEvents = ['DOMContentLoaded', 'turbo:load', 'orchid:screen:rendered'];
            let calendar, rawEvents = [];

            const computeHeight = () => {
                const cal = document.getElementById('appointment-calendar');
                const bar = document.getElementById('filters-bar');
                if (!cal) return;
                const vh = window.innerHeight || document.documentElement.clientHeight;
                const barH = bar ? bar.getBoundingClientRect().height : 0;
                const paddings = 32; // margen/padding aproximado del layout
                cal.style.minHeight = Math.max(480, vh - barH - paddings) + 'px';
            };

            const debounce = (fn, ms = 120) => { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; };
            const applyFilters = () => {
                if (!calendar) return;
                const barberId = (document.getElementById('filter-barber')?.value ?? '').trim();
                const shopId   = (document.getElementById('filter-barbershop')?.value ?? '').trim();

                const filtered = rawEvents.filter(ev => {
                    const eb = String(ev.extendedProps?.barberId ?? '');
                    const es = String(ev.extendedProps?.barbershopId ?? '');
                    return (!barberId || eb === barberId) && (!shopId || es === shopId);
                });

                calendar.removeAllEvents();
                calendar.addEventSource(filtered);
            };

            const init = () => {
                const el = document.getElementById('appointment-calendar');
                if (!el || typeof FullCalendar === 'undefined') return;

                try { rawEvents = JSON.parse(el.dataset.events || '[]'); } catch { rawEvents = []; }

                calendar = new FullCalendar.Calendar(el, {
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
                    stickyHeaderDates: true,
                    locale: document.documentElement.lang || 'es',
                    eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
                    events: [],
                    eventDidMount(info) {
                        const p = info.event.extendedProps || {};
                        const lines = [
                            (p.startsAt && p.endsAt) ? `${p.startsAt} → ${p.endsAt}` : (p.startsAt || ''),
                            p.clientName ? `{{ __('Cliente') }}: ${p.clientName}` : null,
                            p.barberName ? `{{ __('Barbero') }}: ${p.barberName}` : null,
                            p.barbershopName ? `{{ __('Barbería') }}: ${p.barbershopName}` : null,
                            p.serviceName ? `{{ __('Servicio') }}: ${p.serviceName}` : null,
                            p.notes ? `{{ __('Notas') }}: ${p.notes}` : null,
                        ].filter(Boolean);
                        if (lines.length) info.el.setAttribute('title', lines.join('\n'));
                    },
                });

                document.getElementById('filter-barber')?.addEventListener('change', debounce(applyFilters, 80));
                document.getElementById('filter-barbershop')?.addEventListener('change', debounce(applyFilters, 80));

                calendar.render();
                applyFilters();
                computeHeight();
            };

            readyEvents.forEach(e => document.addEventListener(e, init));
            window.addEventListener('resize', debounce(computeHeight, 100));
        })();
    </script>
@endpush
