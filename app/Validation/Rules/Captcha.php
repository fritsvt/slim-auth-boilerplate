<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class Captcha extends AbstractRule
{

    public function validate($input)
    {
        $recaptcha = new \ReCaptcha\ReCaptcha(config('captcha.private'));

        if (!$recaptcha->verify($input, $_SERVER['REMOTE_ADDR'])->isSuccess()) {
            return false;
        } else {
            return true;
        }
    }

}
