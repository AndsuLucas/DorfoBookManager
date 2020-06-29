<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\User;

class Authenticate
{
    /**
     * The authentication guard factory instance.
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
    public function __construct(Auth $auth, User $user)
    {
        $this->user = $user;
        $this->auth = $auth;
    }

    /**
     * Manipula a requisição e verifica se o usuário possui autenticação.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has('access_token')) {
            return response('Unauthorized.', 401);
        }

        $accessToken = $request->get('access_token');
        $user = $this->user->where('token', $accessToken);
        $rows = $user->get();

        $hasUser = !$rows->isEmpty();

        if (!$hasUser) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
