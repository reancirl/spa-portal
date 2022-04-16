<?php

namespace App\Models;

use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetFolder extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name',
        'description',
        'status',
        'category_id',
        'precedence',
        'created_by_user_id',
        'updated_by_user_id',
    ];

    /**
     * Get the category that owns the folder.
     */
    public function category()
    {
        return $this->belongsTo(AssetCategory::class);
    }

    /**
     * Get the count
     *
     * @return int
     */
    public function getCountAttribute()
    {
        return Asset::when(auth()->user()->dealer_id, function ($q) {
            $q->whereJsonContains('dealers', auth()->user()->dealer_id)->orWhereNull('dealers');
        })->active()->where('folder_id', $this->id)->published()->count();
    }

    /**
     * Scope a query to only include active.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
