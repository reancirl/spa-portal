<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'crm_id',
        'dealer_id',
        'is_temp_password',
        'email',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Set the user's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Set the user's temp password.
     *
     * @param  string  $value
     * @return void
     */
    public function setIsTempPasswordAttribute($value)
    {
        $this->attributes['is_temp_password'] = Hash::make($value);
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
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

    /**
     * Get the user's is_admin status.
     *
     * @param  string  $value
     * @return void
     */

    public function getIsAdminAttribute()
    {
        $roles = $this->userRoles()->get();
        $status = false;

        if (!$roles) {
            return false;
        }

        foreach ($roles as $item) {
            if ($item->role->slug == 'admin') {
                $status = true;
                break;
            }
        }

        return $status;
    }

    /**
     * Get the user's fullname
     *
     * @param  string  $value
     * @return void
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
