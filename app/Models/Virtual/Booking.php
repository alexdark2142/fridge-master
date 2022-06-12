<?php

namespace App\Models\Virtual;

use OpenApi\Annotations as OA;

/**
 * Class Booking.
 *
 * @OA\Schema(
 *     title="Booking resource",
 *     description="Booking list for user",
 *     type="object"
 * )
 */
class Booking
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
    private string $location_name;

    /**
     * @OA\Property(
     *     title="Freezing room",
     *     description="Freezing room info",
     *     example={
     *         "id": 36,
     *         "name": "Room48",
     *         "temperature": -32
     *     }
     * )
     *
     * @var object
     */
    private object $freezing_room;

    /**
     * @OA\Property(
     *     title="Blocks",
     *     description="Booking of the number of blocks",
     *     format="int64",
     *     example="35"
     * )
     *
     * @var int
     */
    private int $blocks;

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

    /**
     * @OA\Property(
     *      title="Booking date",
     *      description="Booking date according to location time zone",
     *      default="2022-06-25 18:31:45",
     *      format="datetime",
     *      type="string"
     * )
     *
     * @var \DateTime
     */
    public \DateTime $date_booking_by_tz;

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
