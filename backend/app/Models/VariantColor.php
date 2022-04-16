<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantColor extends Model
{
    use HasFactory;

    public $fillable = [
        'variant_id',
        'color_id',
        'name',
        'price',
        'pricing',
        'code',
        'long_name',
        'status'
    ];

    public function variant(){
        return $this->hasOne('App\Models\Variant', 'id', 'variant_id');
    }
 
    public function color(){
        return $this->hasOne('App\Models\Color', 'id', 'color_id');
    }

}
