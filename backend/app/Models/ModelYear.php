<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelYear extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'code',
        'description',
        'status'
    ];
}
