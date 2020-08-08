<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class ExternalToken extends Model
{
    protected $table = 'external_token';

    /**
     * Retorna se é válido o token de acesso externo
     * @param string $externalToken Token de acesso externo
     * @return bool
     */
    public function isValidExternalToken($externalToken)
    {
        if (empty($externalToken)) {
            return false;
        }

        $token = $this->where('token', '=', $externalToken)->get();

        return !empty($token);
    }

}