<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    /**
     * Атрибути, які можна масово заповнювати.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'slug', 'parent_id', 'image'];

    /**
     * Отримує батьківську категорію цієї категорії.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Отримує всі дочірні категорії цієї категорії.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Отримує всі продукти, які належать цій категорії.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
