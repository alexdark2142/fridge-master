<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static findOrFail(mixed $id)
 * @method static create(array $array)
 */
class FreezingRoom extends Model
{
    use HasFactory;

    public const BLOCK_SIZE = 2;
    public const COST_BLOCK_PER_DAY = 20;

    protected $fillable = [
        'name',
        'location_id',
        'temperature',
        'total_blocks',
    ];

    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
