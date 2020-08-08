<?php
namespace App\Helpers\Validators\User;

trait UserValidatorTrait
{
    protected $userMessages = [
        'required' => ':attribute é um campo obrigátório',
        'unique' => ':attribute já existe',
        'string' => ':attribute deve conter apenas letras',
        'no_numbers' => ':attribute deve conter apenas letras',
        'min' => ':attribute deve ter no mínimo :min dígitos',
        'max' => ':attribute deve ter no máximo :max dígitos',
        'email' => ':attribute com formato inválido'
    ];

    /**
     * Retorna os Alias para cada input da validação do usuário
     * @return array
     */
    private function getAttributesAlias(): array {
        return [
            'email' => 'Email',
            'password' => 'Senha',
            'name' => 'Nome'
        ];
    }
}
