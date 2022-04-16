<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class News extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'slug',
        'image',
        'summary',
        'content',
        'content_url',
        'dealers',
        'precedence',
        'featured',
        'status',
        'published_at',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'dealers' => 'array',
    ];

    public function dealers()
    {
        return $this->hasMany(Dealer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
