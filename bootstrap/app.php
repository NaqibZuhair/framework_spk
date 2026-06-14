<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();

        $middleware->alias([
            'role' => EnsureUserHasRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Terlalu banyak percobaan. Silakan coba lagi beberapa saat.',
                ], Response::HTTP_TOO_MANY_REQUESTS);
            }

            $seconds = (int) ($e->getHeaders()['Retry-After'] ?? 60);

            return back()
                ->withErrors([
                    'email' => 'Terlalu banyak percobaan login. Silakan tunggu sampai tombol login aktif kembali.',
                ])
                ->with('login_throttle_seconds', $seconds)
                ->onlyInput('email');
        });
    })->create();
