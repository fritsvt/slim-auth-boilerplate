<?php

namespace App\Validation\Forms;

use Respect\Validation\Validator as v;

class LoginForm
{

    public static function rules()
    {

        return [
            'email' => v::email(),
            'password' => v::noWhitespace()->notEmpty()->length(5),
            'g-recaptcha-response' => v::notEmpty()->Captcha()
        ];

    }

}
