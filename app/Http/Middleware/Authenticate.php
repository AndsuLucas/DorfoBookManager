<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\User;
use App\ExternalToken;

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
    public function __construct(Auth $auth, User $user, ExternalToken $externalToken)
    {
        $this->user = $user;
        $this->auth = $auth;
        $this->externalToken = $externalToken;
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
        if ($request->has('external_token')) {
            return $this->handleExternalAuth($request, $next);
        }

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

    /**
     * Manipula as requisições externas
     * @param \Illuminate\Http\Request  $request
     * @return mixed
     */
    private function handleExternalAuth($request, Closure $next)
    {
        $externalToken = $request->get('external_token');
        if (empty($externalToken)) {
            return response('Unauthorized.', 401);
        }

        $isAuthAccess = $this->externalToken->isValidExternalToken($externalToken);
        if (empty($isAuthAccess)) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
