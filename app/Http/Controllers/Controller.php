<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     description="Diese Web-App verwaltet Bestellungen und die dazugehörenden Produkte und Geschäfte.
 *     Dieses Projekt wurde im Laufe einer IPA erstellt.",
 *     version="1.0.0",
 *     title="Bestellungs-Übersicht | API-Backend in Laravel",
 *     @OA\Contact(
 *         email="julien.raedler@twofold.swiss"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * )
 * @OA\Tag(
 *     name="user",
 *     description="Verwaltung von Benutzern",
 * )
 * @OA\Tag(
 *     name="shop",
 *     description="Verwaltung von Geschäften",
 * )
 * @OA\Tag(
 *     name="product",
 *     description="Verwaltung von Produkten",
 * )
 * @OA\Tag(
 *     name="order",
 *     description="Verwaltung von Bestellungen",
 * )
 * @OA\Tag(
 *     name="orderProduct",
 *     description="Verwaltung von bestellten Produkten",
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
