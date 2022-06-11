<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $blocks
 * @property mixed $location
 * @property mixed $storage_period
 * @property mixed $cost
 * @property mixed $token
 * @property mixed $freezingRoom
 * @property mixed $id
 */
class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $date = Carbon::parse($this->location->dateByTZ);
        $storagePeriod = 0;

        if ($date->timestamp < Carbon::parse($this->storage_period)->timestamp) {
            $storagePeriod = $date->diffInDays($this->storage_period) + 1;
        }

        return [
            'id'                 => $this->id,
            'location_name'      => $this->location->name,
            'freezing_room'      => new FreezingRoomSimpleResource($this->freezingRoom),
            'blocks'             => $this->blocks,
            'cost'               => $this->cost,
            'storage_period'     => $storagePeriod,
            'date_booking_by_tz' => $this->storage_period,
            'token'              => $this->token,
        ];
    }
}
