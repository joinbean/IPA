<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Catch not found exception for shop routes and return API friendly error message.
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/shops/*')) {
                return response()->json([
                    'message' => 'Shop-Datensatz nicht gefunden.'
                ], 404);
            }
        });

        // Catch not found exception for product routes and return API friendly error message.
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/products/*')) {
                return response()->json([
                    'message' => 'Produktdatensatz nicht gefunden.'
                ], 404);
            }
        });

        // Catch not found exception for order routes and return API friendly error message.
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/orders/*')) {
                return response()->json([
                    'message' => 'Bestelldatensatz nicht gefunden.'
                ], 404);
            }
        });

        // Catch not found exception for orderProduct routes and return API friendly error message.
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/orderProducts/*')) {
                return response()->json([
                    'message' => 'Bestellter Produktdatensatz nicht gefunden.'
                ], 404);
            }
        });
    }
}
