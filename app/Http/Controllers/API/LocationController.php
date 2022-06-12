<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculatorRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\LocationSimpleResource;
use App\Models\Location;
use App\Services\CalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LocationController extends Controller
{
    /**
     * @OA\Get(
     *      path="/locations",
     *      operationId="getLocationsList",
     *      tags={"Locations"},
     *      summary="Get a list of locations",
     *      description="Returns a list of locations",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Location")
     *          ),
     *      ),
     * )
     */
    public function index(): JsonResource
    {
        return LocationSimpleResource::collection(Location::all());
    }

    /**
     * @OA\Get(
     *      path="/locations/{id}",
     *      operationId="getLocationsById",
     *      tags={"Locations"},
     *      summary="Get location information",
     *      description="Returns location data",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Location id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Location")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid ID supplied"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Location not found"
     *      )
     * )
     */
    public function show(int $id): LocationSimpleResource
    {
        return new LocationSimpleResource(Location::findOrFail($id));
    }

    /**
     * @OA\Post(
     *      path="/locations/{id}/calculator",
     *      operationId="calculator",
     *      tags={"Calculator"},
     *      summary="Block Booking Calculator",
     *      description="Returns estimated data",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Location id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CalculatorRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Calculation")
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Incorect data"
     *      )
     * )
     */
    public function calculator(
        CalculatorRequest $request,
        CalculatorService $locationService,
        int $id
    ): LocationResource|JsonResponse {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json(
                [
                    'errors' => $request->validator->errors()
                ],
                ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return new LocationResource($locationService->calculation($id, $request->get('temperature')));
    }
}
