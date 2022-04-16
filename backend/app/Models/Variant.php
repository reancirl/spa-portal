<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{

    use HasFactory;

    protected $guarded = [];

    public function model()
    {
        return $this->hasOne('App\Models\ModelVehicle', 'id', 'model_id');
    }

    public function year()
    {
        return $this->hasOne('App\Models\ModelYear', 'id', 'year_id');
    }
}
