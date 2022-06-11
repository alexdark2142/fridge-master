<?php

namespace App\Models\Virtual;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="Store booking request",
 *      description="Store booking request body data",
 *      type="object",
 *      required={
 *          "total_free_blocks",
 *          "required_blocks",
 *          "freezing_rooms",
 *          "storage_period",
 *          "cost"
 *      }
 * )
 */

class StoreBookingRequest
{
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
