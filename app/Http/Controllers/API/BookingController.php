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
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BookingController extends Controller
{
    /**
     * @OA\Get(
     *      path="/user/{userId}/booking",
     *      operationId="getBookingList",
     *      tags={"Booking"},
     *      summary="Get a list of booking for a user",
     *      description="Returns a list of booking for the user",
     *      @OA\Parameter(
     *          name="userId",
     *          in="path",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Booking")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Booking not found"
     *       )
     * )
     */
    public function list(int $userId): JsonResource
    {
        return BookingResource::collection(Booking::whereUserId($userId)->get());
    }

    /**
     * @OA\Post(
     *      path="/user/{userId}/booking",
     *      operationId="storeBooking",
     *      tags={"Booking"},
     *      summary="Create a booking",
     *      description="Returns message successes",
     *      @OA\Parameter(
     *          name="userId",
     *          in="path",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreBookingRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     * )
     */
    public function store(BookingRequest $request, int $userId): JsonResponse
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json(
                [
                    'errors' => $request->validator->errors()
                ],
                ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if ($request->get('total_free_blocks') < $totalBlocks = $request->get('required_blocks')) {
            return response()->json(
                [
                    'errors' => [
                        'message' => 'Not enough blocks to book. Reduce the volume of goods.'
                    ]
                ],
                ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        DB::transaction(function () use ($request, $totalBlocks, $userId) {
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
                    'user_id' => $userId,
                    'freezing_room_id' => $freezingRoom['id'],
                    'blocks' => $blocks,
                    'storage_period' => $date,
                    'cost' => $request->get('cost'),
                    'token' => Str::random(12)
                ]);
            }
        });

        return response()->json(['message' => 'successes'], ResponseAlias::HTTP_CREATED);
    }
}
