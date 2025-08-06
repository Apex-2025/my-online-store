<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * Атрибути, які можна масово заповнювати.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone_number',
        'address',
        'total_price',
        'status',
    ];

    /**
     * Отримує користувача, який оформив замовлення.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Отримує товари, які входять у замовлення.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
