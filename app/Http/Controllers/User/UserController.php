<?php

namespace App\Http\Controllers\User;

use App\Helpers\Validators\User\UserLoginValidator;
use App\Helpers\Validators\User\UserRegisterValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Symfony\Component\HttpFoundation\Cookie;
use App\Repository\User\UserRepository;

class UserController extends Controller
{
    const VALID_FIELDS = ['email', 'password', 'name'];

    const REGISTER_SUCCESS_MESSAGE = 'Usuário registrado com sucesso.';

    const LOGIN_ERROR_MESSAGE = 'Email ou senha não encontrado.';

    const INSUFICIENT_DATA = 'Digite e-mail e senha por favor.';

    const INVALID_TOKEN = 'Token inválido';

    const HAS_NOT_TOKEN = 'Não identificamos o token na requisição';

    /**
     * @var array $headers
     */
    protected $headers = [];

    /**
     * Regras de validação login do usuário
     * @var UserLoginValidator
     */
    private $userLoginValidator;

    /**
     * Regras de validação cadastro do usuário
     * @var UserLoginValidator
     */
    private $userRegisterValidator;

    /**
     * Model de usuários
     * @var User
     */
    private $userRepository;

    public function __construct(
        UserRepository $userRepository,
        UserLoginValidator $userLoginValidator,
        UserRegisterValidator $userRegisterValidator
    )
    {
        $this->userRepository = $userRepository;
        $this->userLoginValidator = $userLoginValidator;
        $this->userRegisterValidator = $userRegisterValidator;
    }

    /**
     * Faz o login do usuário e retorna o token utilizado
     * acessar os endpoints
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        $this->userLoginValidator->apply($request);
        try {

            $options = [
                'field' => 'email',
                'value' => $request->email,
                'first' => true
            ];

            $user = $this->userRepository->findBy($options);
            $hasUser = !empty($user);
            if (!$hasUser) {
                $jsonResponse = response()->json(self::LOGIN_ERROR_MESSAGE, 401, $this->getHeaders());
                return $jsonResponse;
            }
            
            $isValidLogin = password_verify($request->password, trim($user->password));
            if (!$isValidLogin) {
                $jsonResponse = response()->json(self::LOGIN_ERROR_MESSAGE, 401, $this->getHeaders());
                return $jsonResponse;
            }

            unset($user->password);
            $cookie = new Cookie('SSID', trim($user->token));
            $this->pushHeader('Set-Cookie', (string) $cookie);
            $jsonResponse = response()->json($user, 200, $this->getHeaders());

            return $jsonResponse;

        } catch (\Throwable $th) {
            $jsonResponse = response()->json(self::SERVER_ERROR_MESSAGE, 500, $this->getHeaders());
            return $jsonResponse;
        }

    }

    /**
     * Cadastra um novo usuário.
     * @param Request $request
     * @return string
     */
    public function register(Request $request) {

        $this->userRegisterValidator->apply($request);
        if (!$request->filled(self::VALID_FIELDS)) {
            $jsonResponse = response()->json(self::CLIENT_ERROR_MESSAGE, 400, $this->getHeaders());
            return $jsonResponse;
        }

        $userData = $request->only(self::VALID_FIELDS);
        $userData['password'] = trim(password_hash($userData['password'], PASSWORD_DEFAULT));
        $userData['token'] = generateToken();
    
        try {
            
            $result = $this->userRepository->save($userData);
            if (!$result) {
                $jsonResponse = response()->json(self::CLIENT_ERROR_MESSAGE, 400, $this->getHeaders());
                return $jsonResponse;
            }

            $jsonResponse = response()->json(self::REGISTER_SUCCESS_MESSAGE, 201, $this->getHeaders());
            return $jsonResponse;

        } catch (\Throwable $th) {
            $jsonResponse = response()->json(self::SERVER_ERROR_MESSAGE, 500, $this->getHeaders());
            return $jsonResponse;
        }
    }

    public function getUser(Request $request) {
        $token = $request->cookie('SSID');
        if (!token) {
            // $jsonResponse = response()->json(self::)
        }
    }
}
