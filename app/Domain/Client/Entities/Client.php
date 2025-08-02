<?php

namespace App\Domain\Client\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'birthday',
        'occupation',
    ];
}
