<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Models\User;

class UserNameAvailable extends AbstractRule
{

    public function validate($input)
    {
        return User::where('uname', $input)->count() === 0;
    }

}
