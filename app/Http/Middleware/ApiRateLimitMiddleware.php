<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ApiRateLimitMiddleware
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->ip();
        
        // Allow 60 requests per minute
        if ($this->limiter->tooManyAttempts($key, 60)) {
            return response()->json([
                'message' => 'Too many attempts, please try again later.',
            ], 429);
        }

        $this->limiter->hit($key, 60);

        return $next($request);
    }
}
