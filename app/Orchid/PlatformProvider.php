<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Backwards compatible hook for legacy Orchid versions.
     *
     * @deprecated use registerMainMenu instead.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Dashboard')
                ->icon('bs.bar-chart')
                ->title('Navigation')
                ->route(config('platform.index')),

            Menu::make('Clients')
                ->icon('bs.people')
                ->route('platform.clients')
                ->permission('platform.clients'),

            Menu::make('Barbershops')
                ->icon('bs.scissors')
                ->route('platform.barbershops')
                ->permission('platform.barbershops'),

            Menu::make('Services')
                ->icon('bs.list')
                ->route('platform.services')
                ->permission('platform.services'),

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * Backwards compatible hook for legacy Orchid versions.
     *
     * @deprecated use registerPermissions instead.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),

            ItemPermission::group('Content')
                ->addPermission('platform.clients', 'Clients')
                ->addPermission('platform.barbershops', 'Barbershops')
                ->addPermission('platform.services', 'Services'),
        ];
    }
}
