<?php
namespace App\Helpers\Validators;

use Illuminate\Http\Request;

interface Validator
{
    public function apply(Request $request);
}
