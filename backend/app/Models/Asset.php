<?php

namespace App\Models;

use App\Services\AssetsService;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'category_id',
        'folder_id',
        'name',
        'file',
        'description',
        'extension',
        'size',
        'mime_type',
        'height',
        'width',
        'published_at',
        'expired_at',
        'status',
        'precedence',
        'dealers'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'dealers' => 'array',
    ];

    /**
     * Get the display size.
     *
     * @param  string  $value
     * @return string
     */
    public function getSizeDisplayAttribute()
    {
        return (new AssetsService())->formatSize($this->size);
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

    /**
     * Scope a query to only include active.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now()->toDateTimeString())
            ->where('expired_at', '>', Carbon::now()->toDateTimeString());
    }

    /**
     * Get the category that owns the file.
     */
    public function category()
    {
        return $this->belongsTo(AssetCategory::class);
    }

    /**
     * Get the folder that owns the file.
     */
    public function folder()
    {
        return $this->hasOne(AssetFolder::class);
    }
}
