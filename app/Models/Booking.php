<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @method static create(array $array)
 * @method static whereUserId(int $userId)
 */
class Booking extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'freezing_room_id',
        'blocks',
        'storage_period',
        'cost',
        'token',
    ];

    public function freezingRoom(): BelongsTo
    {
        return $this->belongsTo(FreezingRoom::class);
    }

    public function location(): HasManyThrough
    {
        return $this->hasOneThrough(
            Location::class,
            FreezingRoom::class,
            'id',
            'id',
            'freezing_room_id',
            'location_id',
        );
    }
}
