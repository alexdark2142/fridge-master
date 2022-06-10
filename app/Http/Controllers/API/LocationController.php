<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculationRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\LocationSimpleResource;
use App\Models\Location;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationController extends Controller
{

    public function index(): JsonResource
    {
        return LocationSimpleResource::collection(Location::all());
    }

    public function show(int $id): LocationSimpleResource
    {
        return new LocationSimpleResource(Location::findOrFail($id));
    }

    public function calculation(CalculationRequest $request, int $id): LocationResource|string
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $request->validator->errors()->toJson();
        }

        $temperatures = $this->getTemperatures($request->get('temperature'));

        $location = Location::with([
            'freezingRooms' => function ($q) use ($temperatures) {
                $q->whereBetween('temperature', $temperatures);
            }
        ])
            ->withSum(
                [
                    'freezingRooms' => function ($q) use ($temperatures) {
                        $q->whereBetween('temperature', $temperatures);
                    }
                ],
                'total_blocks'
            )
            ->findOrFail($id);

        return new LocationResource($location);
    }

    private function getTemperatures($temperature): array
    {
        return $temperature !== null
            ? [$temperature - 2, $temperature + 2]
            : [];
    }
}
