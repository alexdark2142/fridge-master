<?php

namespace App\Models\Virtual;

use OpenApi\Annotations as OA;

/**
 * Class Token.
 *
 * @OA\Schema(
 *     title="Token",
 *     description="Booking Token",
 *     type="object"
 * )
 */
class Token
{
    /**
     * @OA\Property(
     *      title="Token",
     *      description="Token for receiving goods",
     *      example="5zruiiV1mFtp"
     * )
     *
     * @var string
     */
    public string $token;
}
