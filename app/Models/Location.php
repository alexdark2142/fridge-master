<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @method static create(string[] $array)
 * @method static findOrFail(int $id)
 */
class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'timezone'
    ];

    public function freezingRooms(): HasMany
    {
        return $this->hasMany(FreezingRoom::class);
    }

    public function booking(): HasManyThrough
    {
        return $this->hasManyThrough(
            Booking::class,
            FreezingRoom::class,
            'location_id',
            'freezing_room_id',
            'id',
            'id'
        );
    }

    public function getDateByTZAttribute(): string
    {
        return Carbon::now()->tz($this->timezone)->format('Y-m-d H:i:s');
    }

    public function getFreeBlocksAttribute(): int
    {
        return $this->freezingRooms()->sum('total_blocks')
            - $this->booking()->where('storage_period', '>', $this->dateByTZ)->sum('blocks');
    }
}
