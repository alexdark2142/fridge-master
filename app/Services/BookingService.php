<?php

namespace App\Services;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingService
{
    public function store(BookingRequest $request, int $userId): void
    {
        DB::transaction(function () use ($request, $userId) {
            $requiredBlocks = $request->get('required_blocks');

            foreach ($request->get('freezing_rooms') as $freezingRoom) {
                $date = $this->getStorageDateByTz($request->get('storage_period'), $request->get('location_tz'));

                if ($freezingRoom['free_blocks'] > $requiredBlocks) {
                    $blocks = $requiredBlocks;
                } else {
                    $blocks = $freezingRoom['free_blocks'];
                    $requiredBlocks = $requiredBlocks - $freezingRoom['free_blocks'];
                }

                Booking::create([
                    'user_id' => $userId,
                    'freezing_room_id' => $freezingRoom['id'],
                    'blocks' => $blocks,
                    'storage_period' => $date,
                    'cost' => $request->get('cost'),
                    'token' => Str::random(12)
                ]);
            }
        });
    }

    private function getStorageDateByTz(string $days, string $timezone): string
    {
        return Carbon::now()
            ->tz($timezone)
            ->addDays($days)
            ->format('Y-m-d H:i:s');
    }
}
