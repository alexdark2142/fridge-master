<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $temperature
 * @property mixed $id
 * @property mixed $name
 * @property mixed $location
 * @property mixed $total_blocks
 * @property mixed $booking
 */
class FreezingRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $bookingBlocks = $this->booking
            ->where('storage_period', '>', $this->location->dateByTZ)
            ->sum('blocks');

        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'temperature' => $this->temperature,
            'free_blocks' => $this->total_blocks - $bookingBlocks,
        ];
    }
}
