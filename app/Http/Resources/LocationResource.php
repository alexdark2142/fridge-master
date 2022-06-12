<?php

namespace App\Http\Resources;

use App\Models\FreezingRoom;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $freezing_rooms_sum_free_blocks
 * @property mixed $name
 * @property mixed $id
 * @property mixed $booking
 * @property mixed $freezingRooms
 * @property mixed $freezing_rooms_sum_total_blocks
 * @property mixed $dateByTZ
 * @property mixed $timezone
 */
class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $blocks = ceil($request->get('goods_volume') / FreezingRoom::BLOCK_SIZE);
        $bookingBlocks = $this->booking
            ->whereIn('freezing_room_id', $this->freezingRooms->pluck('id'))
            ->where('storage_period', '>', $this->dateByTZ)
            ->sum('blocks');

        return [
            'location_id'       => $this->id,
            'location_name'     => $this->name,
            'location_tz'       => $this->timezone,
            'freezing_rooms'    => FreezingRoomResource::collection($this->freezingRooms),
            'total_free_blocks' => $this->freezing_rooms_sum_total_blocks - $bookingBlocks,
            'required_blocks'   => $blocks,
            'cost'              => $blocks * $request->get('storage_period') * FreezingRoom::COST_BLOCK_PER_DAY,
        ];
    }
}
