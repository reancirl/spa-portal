<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerZone extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }
}
