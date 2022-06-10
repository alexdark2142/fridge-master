<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\FreezingRoom;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BookingController extends Controller
{
    public function list(int $userId): JsonResource
    {
        return BookingResource::collection(Booking::whereUserId($userId)->get());
    }

    public function store(BookingRequest $request): JsonResponse
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $request->validator->errors()->toJson();
        }

        if ($request->get('total_free_blocks') < $totalBlocks = $request->get('need_total_blocks')) {
            return response()->json(
                [
                    'error' => [
                        'message' => 'Not enough blocks to book. Reduce the volume of goods.'
                    ]
                ],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        DB::transaction(function () use ($request, $totalBlocks) {
            foreach ($request->get('freezing_rooms') as $freezingRoom) {
                $date = Carbon::now()
                    ->tz(FreezingRoom::findOrFail($freezingRoom['id'])->location->timezone)
                    ->addDays($request->get('storage_period'))
                    ->format('Y-m-d H:i:s');

                if ($freezingRoom['free_blocks'] > $totalBlocks) {
                    $blocks = $totalBlocks;
                } else {
                    $blocks = $freezingRoom['free_blocks'];
                    $totalBlocks = $totalBlocks - $freezingRoom['free_blocks'];
                }

                Booking::create([
                    'user_id'          => $request->get('user_id'),
                    'freezing_room_id' => $freezingRoom['id'],
                    'blocks'           => $blocks,
                    'storage_period'   => $date,
                    'cost'             => $request->get('cost'),
                    'cod'              => Str::random(12)
                ]);
            }
        });

        return response()->json('successes', ResponseAlias::HTTP_CREATED);
    }
}
