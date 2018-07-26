<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Helpers\Config;

class Captcha extends AbstractRule
{

    public function validate($input)
    {
        $recaptcha = new \ReCaptcha\ReCaptcha((new Config())->get('captcha.private'));

        if (!$recaptcha->verify($input, $_SERVER['REMOTE_ADDR'])->isSuccess()) {
            return false;
        } else {
            return true;
        }
    }

}
