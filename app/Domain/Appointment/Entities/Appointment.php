<?php

namespace App\Domain\Appointment\Entities;

use App\Domain\Barbershop\Entities\Barbershop;
use App\Domain\Client\Entities\Client;
use App\Domain\Service\Entities\Service;
use App\Models\User;
use Database\Factories\Domain\Appointment\Entities\AppointmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class Appointment extends Model
{
    use AsSource;
    use HasFactory;

    protected $fillable = [
        'client_id',
        'barber_id',
        'barbershop_id',
        'service_id',
        'starts_at',
        'ends_at',
        'notes',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected static function newFactory(): AppointmentFactory
    {
        return AppointmentFactory::new();
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function barber(): BelongsTo
    {
        return $this->belongsTo(User::class, 'barber_id');
    }

    public function barbershop(): BelongsTo
    {
        return $this->belongsTo(Barbershop::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
