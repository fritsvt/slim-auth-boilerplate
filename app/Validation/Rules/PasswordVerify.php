<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Models\User;

class PasswordVerify extends AbstractRule
{

    protected $password;
    protected $newpass;

    public function __construct($password, $newpass)
    {
        $this->password = $password;
        $this->newpass = $newpass;
    }

    public function validate($input)
    {
        if ($this->password == $this->newpass) {
            return true;
        }
        else {
            return false;
        }
    }

}
