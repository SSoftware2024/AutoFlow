<?php

namespace App\Exceptions;

use App\Facade\MessagesFactory;
use Throwable;
use Inertia\Inertia;
use Inertia\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
    }

    public function render($request, Throwable $e)
{
    $response = parent::render($request, $e);

    if (app()->environment('production') && in_array($response->status(), [500, 503, 404, 403,429])) {
        MessagesFactory::alertSwal()->error($e->getMessage(),$response->status())->generate();
        return back();
    } elseif ($response->status() === 419) {
        return back()->with([
            'message' => 'The page expired, please try again.',
        ]);
    }

    return $response;
}
}
