<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Listing extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'type', 'name', 'slug', 'detail', 'country',
        'state', 'city', 'area', 'price', 'status','sub_cat_id',
    ];

    protected $casts = ['price' => 'decimal:2'];

    protected static function booted(): void
    {
        static::creating(function (Listing $listing) {
            if (!$listing->slug) {
                $listing->slug = Str::slug($listing->name) . '-' . Str::lower(Str::random(6));
            }
        });
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function images(): HasMany { return $this->hasMany(ListingImage::class)->orderBy('sort_order'); }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
