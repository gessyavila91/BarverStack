<?php

declare(strict_types=1);

use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Appointment\AppointmentEditScreen;
use App\Orchid\Screens\Appointment\AppointmentListScreen;
use App\Orchid\Screens\Barbershop\BarbershopEditScreen;
use App\Orchid\Screens\Barbershop\BarbershopListScreen;
use App\Orchid\Screens\Client\ClientEditScreen;
use App\Orchid\Screens\Client\ClientListScreen;
use App\Orchid\Screens\Service\ServiceEditScreen;
use App\Orchid\Screens\Service\ServiceListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Custom business screens
Route::screen('barbershops', BarbershopListScreen::class)->name('platform.barbershops');
Route::screen('barbershops/create', BarbershopEditScreen::class)->name('platform.barbershops.create');
Route::screen('barbershops/{barbershop}/edit', BarbershopEditScreen::class)->name('platform.barbershops.edit');
Route::screen('clients', ClientListScreen::class)->name('platform.clients');
Route::screen('clients/create', ClientEditScreen::class)->name('platform.clients.create');
Route::screen('clients/{client}/edit', ClientEditScreen::class)->name('platform.clients.edit');
Route::screen('services', ServiceListScreen::class)->name('platform.services');
Route::screen('services/create', ServiceEditScreen::class)->name('platform.services.create');
Route::screen('services/{service}/edit', ServiceEditScreen::class)->name('platform.services.edit');
Route::screen('appointments', AppointmentListScreen::class)->name('platform.appointments');
Route::screen('appointments/create', AppointmentEditScreen::class)->name('platform.appointments.create');
Route::screen('appointments/{appointment}/edit', AppointmentEditScreen::class)->name('platform.appointments.edit');
