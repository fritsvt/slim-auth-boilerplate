<?php

namespace App\Validation\Rules;

class ReCaptcha
{
    public function validate(
        $attribute, $value, $parameters, $validator
    ) {
        $recaptcha = new \ReCaptcha\ReCaptcha(config('captcha.private'));
        if ($recaptcha->verify($value, $_SERVER['REMOTE_ADDR'])->isSuccess()) {
            return true;
        }

        return false;
    }
}
