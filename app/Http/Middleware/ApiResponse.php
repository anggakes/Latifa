<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

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

        /** @var Response $response */
        $response = $next($request);
        $original = $response->getOriginalContent();

        if($response->getStatusCode() == 200){
            $response->setContent(json_encode([
                'status' => 'success',
                'data' => $original
            ]));
        }

        return $response;
    }
}
