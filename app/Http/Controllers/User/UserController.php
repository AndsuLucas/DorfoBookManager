<?php 

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller 
{
    const VALID_FIELDS = ['email', 'password', 'name'];

    public function login(Request $request)
    {
        
    }

    public function register(Request $request) {
        if (!$request->filled(self::VALID_FIELDS)) {
                dd('error');
        }

        $userData = $request->only(self::VALID_FIELDS);
        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        $userData['token'] = generateToken();
        dd($userData);
        
    }

}