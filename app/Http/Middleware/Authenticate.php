<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\User;
use App\ExternalToken;
use App\Repository\User\UserRepository;

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
    public function __construct(Auth $auth, UserRepository $userRepository, ExternalToken $externalToken)
    {
        $this->userRepository = $userRepository;
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

        $token = $request->cookie('SSID');
        if (empty($token)) {
            return response('Unauthorized.', 401);
        }

        $options = [
            'field' => 'token',
            'value' => $token,
            'first' => true
        ];

        $user = $this->userRepository->findBy($options);
        if (!$user) {
            return response('Unauthorized.', 401);
        }


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
