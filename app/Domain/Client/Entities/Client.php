<?php

namespace App\Domain\Client\Entities;

use App\Domain\Appointment\Entities\Appointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class Client extends Model
{
    use AsSource;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'birthday',
        'occupation',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
