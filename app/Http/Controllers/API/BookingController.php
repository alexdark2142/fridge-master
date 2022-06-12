<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
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
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page number",
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
        return BookingResource::collection(Booking::whereUserId($userId)->paginate(5));
    }

    /**
     * @OA\Get(
     *      path="/booking/{id}/token",
     *      operationId="getToken",
     *      tags={"Booking"},
     *      summary="Token for delivery or receipt of goods",
     *      description="Return token",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Booking ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Token")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Booking not found"
     *       )
     * )
     */
    public function getToken(int $id): JsonResponse
    {
        return response()->json(['token' => Booking::findOrFail($id)->token]);
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
    public function store(BookingRequest $request, BookingService $bookingService, int $userId): JsonResponse
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json(
                [
                    'errors' => $request->validator->errors()
                ],
                ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if ($request->get('total_free_blocks') < $request->get('required_blocks')) {
            return response()->json(
                [
                    'errors' => [
                        'message' => 'Not enough blocks to book. Reduce the volume of goods.'
                    ]
                ],
                ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $bookingService->store($request, $userId);

        return response()->json(['message' => 'successes'], ResponseAlias::HTTP_CREATED);
    }
}
