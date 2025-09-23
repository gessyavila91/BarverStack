<?php

namespace App\Domain\Barbershop\Entities;

use App\Domain\Appointment\Entities\Appointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

class Barbershop extends Model
{
    use AsSource;
    use HasFactory;

    protected $table = 'barbershops';

    protected $fillable = [
        'name',
        'address',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
