<?php

namespace App\Domain\Barbershop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
