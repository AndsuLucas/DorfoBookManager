<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    const SERVER_ERROR_MESSAGE = <<<EOT
    Ocorreu um erro. Por favor tente novamente mais tarde ou contate o Anderson Lucas Silva de Oliveira.
    EOT;

    const CLIENT_ERROR_MESSAGE = <<<EOT
    Cheque se você inseriu todos os campos de forma correta.
    EOT;

    const HEADERS = ['Content-type'=> 'application/json;charset=utf-8'];

    /**
     * Retorna os headers customizados concatenados com os default
     * @return array headers
     */
    protected function getHeaders(): array
    {
        if (empty($this->headers)) {
            return self::HEADERS;
        }

        return array_merge($this->headers, self::HEADERS);
    }

    /**
     * Adiciona um header aos já existentes
     * @param string $headerName Chave do header
     * @param string $value Valor do header
     * @return void
     */
    protected function pushHeader(string $headerName, string $value): void
    {
        $this->headers[$headerName] = $value;
    }
}
