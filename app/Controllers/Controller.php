<?php

namespace App\Controllers;

use App\Validation\ValidatorFactory;

abstract class Controller
{
    protected $validator;

    public function __construct(ValidatorFactory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validate request
     *
     * @param $request
     * @param $rules
     * @return mixed
     */
    public function validate($request, $rules)
    {
        if (is_array($request)) {
            $data = $request;
        } else {
            $data = $request->getParsedBody();
            if ($data == null) {
                $data = [];
            }
        }

        return $this->validator->make($data, $rules);
    }
}