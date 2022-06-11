<?php

namespace App\Models\Virtual;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="Calculator request",
 *      description="Calculator request body data",
 *      type="object",
 *      required={"goods_volume", "temperature", "storage_period"}
 * )
 */

class CalculatorRequest
{
    /**
     * @OA\Property(
     *      title="Volume of goods",
     *      description="Volume of goods",
     *      format="int64",
     *      example=158
     * )
     *
     * @var integer
     */
    public int $goods_volume;

    /**
     * @OA\Property(
     *      title="Temperature",
     *      description="Temperature freezing room",
     *      format="int64",
     *      example=-10
     * )
     *
     * @var integer
     */
    public int $temperature;

    /**
     * @OA\Property(
     *      title="Storage period",
     *      description="Products storage period",
     *      format="int64",
     *      example=12
     * )
     *
     * @var integer
     */
    public int $storage_period;
}
