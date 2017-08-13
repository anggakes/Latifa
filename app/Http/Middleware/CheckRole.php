<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Tymon\JWTAuth\JWTGuard;

class CheckRole
{

    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param array $guards
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard_) {

            /** @var JWTGuard $guard */
            $guard = $this->auth->guard($guard_);
            $role = $guard->getUser()->getJWTCustomClaims()['role'];
            if($role != $guard_)
                throw new AuthenticationException('Unauthenticated.', $guards);
        }

        return $next($request);
    }
}
