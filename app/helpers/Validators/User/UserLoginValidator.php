<?php
namespace App\Helpers\Validators\User;

use App\Helpers\Validators\User\UserValidatorTrait;
use App\Helpers\Validators\Validator as ValidatorInterface;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class UserLoginValidator implements ValidatorInterface
{

    use ProvidesConvenienceMethods, UserValidatorTrait;

    /**
     * Aplica as regras de validação para os dados do usuário
     * @return void
     */
    public function apply(Request $request): void
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required'
        ], $this->userMessages, $this->getAttributesAlias());
    }
}
