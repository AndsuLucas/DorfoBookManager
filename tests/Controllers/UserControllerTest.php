<?php

use App\Helpers\Validators\User\UserLoginValidator;
use App\Http\Controllers\User\UserController;
use App\Repository\User\UserRepository;
use Illuminate\Http\Request;
use App\User;
use \Mockery\LegacyMockInterface;

class UserControllerTest extends TestCase
{
    // protected ?UserController $userControllerClass;

    protected Request $requestClass;

    protected ?LegacyMockInterface $userRepositoryMock;

    protected ?LegacyMockInterface $UserLoginValidator;

    public function setUp(): void
    {
        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->UserLoginValidator =  Mockery::mock(UserLoginValidator::class);

        $this->requestClass = app()->make(Request::class);
        parent::setUp();
    }

    private function constructLoginController(array $loginDependences = [])
    {
        $this->userControllerClass = app()->makeWith(
            UserController::class,
            [
                'userRepository' => $loginDependences['userRepository'] ?? $this->userRepositoryMock,
                'userValidator' => $loginDependence['userValidator'] ?? $this->UserLoginValidator
            ]
        );
    }

    /**
     * @dataProvider loginDataProvider
     */
    public function testCorrectLogin($userCollection)
    {
        $this->requestClass['email'] = 'teste@teste';
        $this->requestClass['password'] = '123456';
        $this->constructLoginController();

        $this->UserLoginValidator->shouldReceive('apply');
        $this->userRepositoryMock->shouldReceive('findBy')->andReturn($userCollection);
        $result = $this->userControllerClass->login($this->requestClass);

        $SSIDcookie = array_filter(
            $result->headers->getCookies(),
            fn($cookie)=>$cookie->getName() == 'SSID'
        );

        $this->assertNotEmpty($SSIDcookie);
        $this->assertEquals($SSIDcookie[0]->getValue(), $userCollection->token);

    }

    /**
     * @dataProvider loginDataProvider
     */
    public function testLoginWithInvalidPassswordReturnError($userCollection)
    {
        $this->requestClass['email'] = 'teste@teste';
        $this->requestClass['password'] = '1234456';
        $this->constructLoginController();

        $this->UserLoginValidator->shouldReceive('apply');
        $this->userRepositoryMock->shouldReceive('findBy')->andReturn($userCollection);
        $result = $this->userControllerClass->login($this->requestClass);

        $this->assertEquals($result->getStatusCode(), 401);
        $this->assertEquals($result->getData(), "Email ou senha não encontrado.");
    }

    public function testLoginWithInexistentUserReturnError()
    {
        $this->requestClass['email'] = 'teste@teste';
        $this->requestClass['password'] = '1234456';
        $this->constructLoginController();

        $this->UserLoginValidator->shouldReceive('apply');
        $this->userRepositoryMock->shouldReceive('findBy')->andReturn([]);
        $result = $this->userControllerClass->login($this->requestClass);
        $this->assertEquals($result->getStatusCode(), 401);
        $this->assertEquals($result->getData(), "Email ou senha não encontrado.");
    }

    public function loginDataProvider()
    {
        $userCollection = app()->make(User::class);
        $userCollection->id = 13;
        $userCollection->name = 'Anderson Lucas222';
        $userCollection->email = 'teste@teste';
        $userCollection->token = '378aae8eadf241a787d4ec612f680e68';
        $userCollection->password = '$2y$10$Gs8tYD1wrGU6Jpw2dc7BKe1ZN2qGprMqNLyOMEjVQ57Kn30KqHh/.';
        return [
            [$userCollection]
        ];
    }
}
