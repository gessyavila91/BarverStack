<?php

namespace App\Domain\Service\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Service extends Model
{
    use AsSource;
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'cost',
    ];
}
