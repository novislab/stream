<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Shetabit\Visitor\Middlewares\LogVisits;
use Symfony\Component\HttpFoundation\Response;

class LogGetVisits
{
    public function __construct(protected LogVisits $logVisits) {}

    public function handle(Request $request, Closure $next): Response
    {
        // Only log GET requests to avoid tracking Livewire POST requests
        if ($request->isMethod('GET')) {
            return $this->logVisits->handle($request, $next);
        }

        return $next($request);
    }
}
