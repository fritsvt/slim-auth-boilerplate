<?php

namespace App\Validation\Contracts;
use Psr\Http\Message\ServerRequestInterface as Request;

interface ValidatorInterface
{
    public function validate(Request $request, array $rules);
    public function fails();
}
