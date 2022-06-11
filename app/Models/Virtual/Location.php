<?php

namespace App\Models\Virtual;

use OpenApi\Annotations as OA;

/**
 * Class Location.
 *
 * @OA\Schema(
 *     title="Location resource",
 *     description="Location info",
 * )
 */
class Location
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=3
     * )
     *
     * @var int
     */
    private int $id;

    /**
     * @OA\Property(
     *     title="Location name",
     *     description="Location name",
     *     example="Toronto"
     * )
     *
     * @var string
     */
    private string $name;

    /**
     * @OA\Property(
     *     title="Total number of free blocks",
     *     description="Total number of free blocks",
     *     format="int64",
     *     example="450"
     * )
     *
     * @var int
     */
    private int $total_free_blocks;
}
