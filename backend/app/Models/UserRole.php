<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $guarded =[];
    public $timestamps = false;

    public function user()
    {
        /**
         *  old relation
         * return $this->hasMany(User::class);
         */

        return $this->belongsTo(User::class);

    }

    public function role()
    {
        /**
         *  old relation
         * return $this->hasMany(Role::class);
         */
        return $this->belongsTo(Role::class);
    }
}
