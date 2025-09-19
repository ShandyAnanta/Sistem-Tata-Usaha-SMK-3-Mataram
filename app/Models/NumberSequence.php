<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NumberSequence extends Model
{
    use HasFactory;

    protected $table = 'number_sequences';

    protected $fillable = [
        'prefix',
        'last_number',
    ];
}
