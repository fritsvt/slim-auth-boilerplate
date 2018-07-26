<?php

namespace App\Validation\Forms;

use Respect\Validation\Validator as v;

class RegisterForm
{

    public static function rules($auth, $password, $newpass)
    {

        return [
            'name' => v::alnum('_')->length(3, 20),
            'email' => v::email()->EmailAvailable(),
            'password' => v::noWhitespace()->notEmpty()->length(5),
            'password_verify' => v::PasswordVerify($password, $newpass)->notEmpty()->length(5),
            'g-recaptcha-response' => v::notEmpty()->Captcha()
        ];

    }

}
