<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use Searchable;

    protected $fillable = [
        'title',
        'brand_model',
        'description',
        'tags',
        'price',
        'category_id',
        'user_id',
        'is_highlighted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function setAccepted($value)
    {
        $this->is_accepted = $value;
        $this->save();

        return true;
    }

    public static function toBeRevisionedCount()
    {
        return Article::whereNull('is_accepted')->count();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'brand_model' => $this->brand_model,
            'description' => $this->description,
            'tags' => $this->tags,
            'category' => $this->category?->name,
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
