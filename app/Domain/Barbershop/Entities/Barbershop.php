<?php

namespace App\Domain\Barbershop\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbershop extends Model
{
    use HasFactory;

    protected $table = 'barbershops';

    protected $fillable = [
        'name',
        'address',
    ];
}
