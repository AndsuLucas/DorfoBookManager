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
}
