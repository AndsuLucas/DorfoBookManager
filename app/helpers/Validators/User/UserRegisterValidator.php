<?php
namespace App\Helpers\Validators\User;
use App\Helpers\Validators\User\UserValidatorTrait;
use Illuminate\Http\Request;
use App\Helpers\Validators\Validator as ValidatorInterface;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class UserRegisterValidator implements ValidatorInterface
{
    use ProvidesConvenienceMethods, UserValidatorTrait;
    public function apply(Request $request): void
    {
        Validator::extend('noNumbers', function($field, $value) {
            $hasOnlyLetters = preg_match_all('/[0-9]/', $value) === 0;
            return $hasOnlyLetters;
        });

        $this->validate($request, [
            'email' => 'email|required|unique:users',
            'password' => 'required|min:8|max:16',
            'name' => 'required|string|max:100|noNumbers'
        ], $this->userMessages, $this->getAttributesAlias());
    }
}
