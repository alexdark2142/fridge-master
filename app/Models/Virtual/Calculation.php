<?php

namespace App\Models\Virtual;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="Booking calculations",
 *      description="Booking data calculations",
 *      type="object"
 * )
 */

class Calculation
{
    /**
     * @OA\Property(
     *      title="Location ID",
     *      description="Location ID",
     *      format="int64",
     *      example=3
     * )
     *
     * @var integer
     */
    public int $location_id;

    /**
     * @OA\Property(
     *      title="Location name",
     *      description="Location name",
     *      example="Toronto"
     * )
     *
     * @var integer
     */
    public int $location_name;

    /**
     * @OA\Property(
     *      title="Location timezone",
     *      description="Location timezone",
     *      example="America/Toronto"
     * )
     *
     * @var integer
     */
    public int $location_tz;

    /**
     * @OA\Property(
     *      title="Freezing rooms",
     *      description="list of suitable freezing rooms",
     *      example={
     *          {
     *              "id": 3,
     *              "free_blocks": 50
     *          },
     *          {
     *              "id": 4,
     *              "free_blocks": 50
     *          }
     *      }
     * )
     *
     * @var object
     */
    public object $freezing_rooms;

    /**
     * @OA\Property(
     *      title="Total number of free blocks",
     *      description="Total number of free blocks",
     *      format="int64",
     *      example=100
     * )
     *
     * @var integer
     */
    public int $total_free_blocks;

    /**
     * @OA\Property(
     *      title="Required blocks",
     *      description="Required number of  blocks",
     *      format="int64",
     *      example=68
     * )
     *
     * @var integer
     */
    public int $required_blocks;

    /**
     * @OA\Property(
     *      title="Cost",
     *      description="Price for storage of goods",
     *      format="int64",
     *      example=18960
     * )
     *
     * @var integer
     */
    public int $cost;
}
