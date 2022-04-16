<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'bank_details' => 'object',
    ];

    public function dealerGroup()
    {
        return $this->hasOne(DealerGroup::class, 'id', 'group_id', 'dealer_groups');
    }

    public function dealerZone()
    {
        return $this->hasOne(DealerZone::class, 'id', 'zone_id', 'dealer_zones');
    }

    public function leads()
    {
        return $this->hasMany(Leads::class,'dealer_id','id','leads');
    }



    /**
     * Scope a query to only include with dealer_zone and dealer group.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param mixed $dealer_zone_id, $dealer_group_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfDealerFilter($query, $dealer_zone_id, $dealer_group_id = null)
    {
        // if empty
        if (!$dealer_zone_id && !$dealer_group_id) {
            return $query;
        }
        //if has dealer_zone_id but no dealer_group_id
        elseif ($dealer_zone_id && !$dealer_group_id) {
            return $query->where('zone_id', $dealer_zone_id);
        }
        //if has dealer_group_id but no dealer_zone_id
        elseif ($dealer_group_id && !$dealer_zone_id) {
            return $query->where('group_id', $dealer_group_id);
        } else {
            return $query->where('group_id', $dealer_group_id)
                ->where('zone_id', $dealer_zone_id);
        }
    }
}
