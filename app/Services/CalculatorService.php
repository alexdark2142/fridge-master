<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class CalculatorService
{
    public function calculation(int $id, int $temperature): ?Model
    {
        $temperatureRange = $this->getTemperatureRange($temperature);

        return Location::with([
            'freezingRooms' => function ($q) use ($temperatureRange) {
                $q->whereBetween('temperature', $temperatureRange);
            }
        ])
            ->withSum(
                [
                    'freezingRooms' => function ($q) use ($temperatureRange) {
                        $q->whereBetween('temperature', $temperatureRange);
                    }
                ],
                'total_blocks'
            )
            ->findOrFail($id);
    }

    private function getTemperatureRange(?int $temperature): array
    {
        return $temperature !== null
            ? [$temperature - 2, $temperature + 2]
            : [];
    }
}
