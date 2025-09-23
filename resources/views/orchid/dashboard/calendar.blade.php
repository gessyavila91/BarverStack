@php
    use Illuminate\Support\Collection;

    /** @var Collection|\App\Domain\Appointment\Entities\Appointment[] $appointments */
    $palette = [
        ['bg' => '#0ea5e9', 'border' => '#0284c7', 'text' => '#f8fafc'],
        ['bg' => '#6366f1', 'border' => '#4f46e5', 'text' => '#f8fafc'],
        ['bg' => '#14b8a6', 'border' => '#0d9488', 'text' => '#0f172a'],
        ['bg' => '#f97316', 'border' => '#ea580c', 'text' => '#0f172a'],
        ['bg' => '#ec4899', 'border' => '#db2777', 'text' => '#fdf2f8'],
        ['bg' => '#8b5cf6', 'border' => '#7c3aed', 'text' => '#f8fafc'],
        ['bg' => '#f59e0b', 'border' => '#d97706', 'text' => '#0f172a'],
        ['bg' => '#22c55e', 'border' => '#16a34a', 'text' => '#052e16'],
    ];
    $paletteCount = count($palette);
    $assignedColors = [];

    $resolveColor = static function (?int $barberId) use (&$assignedColors, $palette, $paletteCount): array {
        $key = $barberId ?? 'default';

        if (!isset($assignedColors[$key])) {
            $index = count($assignedColors) % max($paletteCount, 1);
            $assignedColors[$key] = $palette[$index] ?? ['bg' => '#3b82f6', 'border' => '#1d4ed8', 'text' => '#f8fafc'];
        }

        return $assignedColors[$key];
    };

    $calendarEvents = collect($appointments ?? [])
        ->filter(static fn ($a) => !empty($a->starts_at))
        ->map(static function ($a) use ($resolveColor) {
            $start = optional($a->starts_at)->toIso8601String();
            $end   = optional($a->ends_at)->toIso8601String() ?: $start;

            $client = optional($a->client)->name;
            $barber = optional($a->barber)->name;
            $svc    = optional($a->service)->name;
            $shop   = optional($a->barbershop)->name;
            $colors = $resolveColor(optional($a->barber)->id);

            return [
                'id'    => $a->id,
                'title' => trim(($client ?? __('Cita')) . ($svc ? " · {$svc}" : '')),
                'start' => $start,
                'end'   => $end,
                'allDay' => false,
                'backgroundColor' => $colors['bg'] ?? '#0ea5e9',
                'borderColor' => $colors['border'] ?? '#0284c7',
                'textColor' => $colors['text'] ?? '#f8fafc',
                'classNames' => ['appointment-event'],
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
        .fc .appointment-event { border-radius: .5rem; border: none; padding: .35rem .45rem; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .18); }
        .fc .appointment-event .fc-appointment__content { display: flex; flex-direction: column; gap: .2rem; color: inherit; }
        .fc .appointment-event .fc-appointment__time { font-size: .65rem; font-weight: 600; letter-spacing: .02em; text-transform: uppercase; opacity: .85; }
        .fc .appointment-event .fc-appointment__title { font-size: .85rem; font-weight: 700; line-height: 1.1; }
        .fc .appointment-event .fc-appointment__meta { font-size: .7rem; line-height: 1.1; opacity: .9; }
        .fc .appointment-event .fc-appointment__meta span { display: inline-block; }
        .fc .fc-daygrid-event { border-radius: .45rem; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        (function () {
            const readyEvents = ['DOMContentLoaded', 'turbo:load', 'orchid:screen:rendered'];
            let calendar;
            let rawEvents = [];
            let listenersRegistered = false;

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

                calendar.removeAllEventSources();
                calendar.addEventSource(filtered);
            };

            const init = () => {
                const el = document.getElementById('appointment-calendar');
                if (!el || typeof FullCalendar === 'undefined') return;

                if (!calendar) {
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
                        slotDuration: '00:30:00',
                        slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
                        expandRows: true,
                        height: 'auto',
                        navLinks: true,
                        nowIndicator: true,
                        stickyHeaderDates: true,
                        locale: document.documentElement.lang || 'es',
                        displayEventTime: false,
                        eventDisplay: 'block',
                        eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
                        events: [],
                        eventContent(arg) {
                            const p = arg.event.extendedProps || {};
                            const root = document.createElement('div');
                            root.className = 'fc-appointment__content';

                            const clamp = (value, limit = 70) => {
                                if (!value) return '';
                                const text = String(value);
                                return text.length > limit ? `${text.slice(0, limit - 1)}…` : text;
                            };

                            const fallbackTime = () => {
                                if (!arg.event?.start) return '';
                                const lang = document.documentElement.lang || 'es';
                                const fmt = new Intl.DateTimeFormat(lang, { hour: '2-digit', minute: '2-digit' });
                                const start = fmt.format(arg.event.start);
                                if (!arg.event.end) return start;
                                return `${start} – ${fmt.format(arg.event.end)}`;
                            };

                            const timeText = arg.timeText || fallbackTime();

                            if (timeText) {
                                const time = document.createElement('div');
                                time.className = 'fc-appointment__time';
                                time.textContent = timeText;
                                root.appendChild(time);
                            }

                            const title = document.createElement('div');
                            title.className = 'fc-appointment__title';
                            title.textContent = clamp(arg.event.title || p.clientName || '{{ __('Cita') }}', 60);
                            root.appendChild(title);

                            const appendMeta = (value) => {
                                if (!value) return;
                                const meta = document.createElement('div');
                                meta.className = 'fc-appointment__meta';
                                const span = document.createElement('span');
                                span.textContent = clamp(value, 70);
                                meta.appendChild(span);
                                root.appendChild(meta);
                            };

                            appendMeta(p.serviceName ? `{{ __('Servicio') }}: ${p.serviceName}` : null);
                            appendMeta(p.barberName ? `{{ __('Barbero') }}: ${p.barberName}` : null);
                            appendMeta(p.barbershopName ? `{{ __('Barbería') }}: ${p.barbershopName}` : null);
                            appendMeta(p.notes ? `{{ __('Notas') }}: ${p.notes}` : null);

                            return { domNodes: [root] };
                        },
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

                    calendar.render();
                }

                if (!listenersRegistered) {
                    document.getElementById('filter-barber')?.addEventListener('change', debounce(applyFilters, 80));
                    document.getElementById('filter-barbershop')?.addEventListener('change', debounce(applyFilters, 80));
                    listenersRegistered = true;
                }

                applyFilters();
                computeHeight();
            };

            readyEvents.forEach(e => document.addEventListener(e, init));
            if (document.readyState !== 'loading') {
                init();
            }
            window.addEventListener('resize', debounce(computeHeight, 100));
        })();
    </script>
@endpush
