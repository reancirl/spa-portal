<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assignedSC()
    {
        return $this->belongsTo(User::class, 'assigned_sc_user_id', 'id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class);
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
