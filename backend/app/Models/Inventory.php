<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = 'inventories';

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Scope a query to only include with dealer.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param mixed $dealer_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfDealer($query, $dealer_id)
    {
        if (!$dealer_id) {
            return $query;
        }

        return $query->where('dealer_id', $dealer_id);
    }
}
