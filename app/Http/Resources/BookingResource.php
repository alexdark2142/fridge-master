<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $blocks
 * @property mixed $location
 * @property mixed $storage_period
 * @property mixed $cost
 * @property mixed $token
 * @property mixed $freezingRoom
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
        return [
            'location'      => $this->location->name,
            'freezing_room' => new FreezingRoomSimpleResource($this->freezingRoom),
            'blocks'        => $this->blocks,
            'storage_up_to' => $this->storage_period,
            'cost'          => $this->cost,
            'token'         => $this->token,
        ];
    }
}
