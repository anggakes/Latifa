<?php

namespace App\Http\Middleware;

use Closure;

class ApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);
        $original = $response->getOriginalContent();

        $response->setContent(json_encode([
            'success' => true,
            'data' => $original
        ]));

        return $response;
    }
}
