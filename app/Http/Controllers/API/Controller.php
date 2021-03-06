<?php

namespace App\Http\Controllers\API;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Fridge Master API documentation",
 *     version="1.0.0",
 *     @OA\Contact(
 *          email="alexdark2149@gmail.com"
 *     )
 * )
 * @OA\Tag(
 *     name="Locations",
 *     description="Locations where there are freezing rooms."
 * )
 * @OA\Tag(
 *     name="Calculator",
 *     description="Calculate booking details"
 * )
 * @OA\Tag(
 *     name="Booking",
 *     description="Storage blocks booking."
 * )
 * @OA\Server (
 *     description="Fridge Master API server",
 *     url="http://localhost/api"
 * )
 */
class Controller extends \App\Http\Controllers\Controller
{
}
