<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    const VALID_FIELDS = ['email', 'password', 'name'];

    const REGISTER_SUCCESS_MESSAGE = 'Usuário registrado com sucesso.';

    const LOGIN_ERROR_MESSAGE = 'Email ou senha não encontrado.';

    const INSUFICIENT_DATA = 'Digite e-mail e senha por favor.';

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    /**
     * Faz o login do usuário e retorna o token utilizado
     * acessar os endpoints
     *
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        $requestData = ['email', 'password'];
        if (!$request->filled($requestData)) {
            $jsonResponse = response()->json(self::INSUFICIENT_DATA , 400, self::HEADERS);
            return $jsonResponse;
        }

        try {

            $user = $this->userModel->where('email', '=', $request->email)->first();
            $userData = $user->get();

            if ($userData->isEmpty()) {
                $jsonResponse = response()->json(self::LOGIN_ERROR_MESSAGE, 400, self::HEADERS);
                return $jsonResponse;
            }

            $isValidLoggin = password_verify($request->password, trim($userData[0]->password));

            if (!$isValidLoggin) {
                $jsonResponse = response()->json(self::LOGIN_ERROR_MESSAGE, 401, self::HEADERS);
                return $jsonResponse;
            }

            $jsonResponse = response()->json(trim($userData[0]->token), 200, self::HEADERS);
            return $jsonResponse;

        } catch (\Throwable $th) {

            $jsonResponse = response()->json(self::LOGIN_ERROR_MESSAGE, 500, self::HEADERS);
            return $jsonResponse;
        }

    }

    /**
     * Cadastra um novo usuário.
     * @param Request $request
     *
     * @return string
     */
    public function register(Request $request) {
        if (!$request->filled(self::VALID_FIELDS)) {
            $jsonResponse = response()->json(self::CLIENT_ERROR_MESSAGE, 400, self::HEADERS);
            return $jsonResponse;
        }

        $userData = $request->only(self::VALID_FIELDS);
        $userData['password'] = trim(password_hash($userData['password'], PASSWORD_DEFAULT));
        $userData['token'] = generateToken();

        try {

            $result = $this->userModel->create($userData);
            if (!$result) {
                $jsonResponse = response()->json(self::CLIENT_ERROR_MESSAGE, 400, self::HEADERS);
                return $jsonResponse;
            }

            $jsonResponse = response()->json(self::REGISTER_SUCCESS_MESSAGE, 201, self::HEADERS);
            return $jsonResponse;

        } catch (\Throwable $th) {

            $jsonResponse = response()->json(self::SERVER_ERROR_MESSAGE, 500, self::HEADERS);
            return $jsonResponse;
        }
    }
}
