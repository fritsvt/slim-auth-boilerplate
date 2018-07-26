<?php

namespace App\Helpers;

class Config
{
	protected $data;
    protected $default;

    public function __construct()
    {
        $this->data = require __DIR__ . '/../../bootstrap/config.php';
    }

    public function get($key, $default = null)
    {
        $this->default = $default;

        $segments = explode('.', $key);
        $data = $this->data;

        foreach ($segments as $segment) {
            if (isset($data[$segment])) {
                $data = $data[$segment];
            } else {
                $data = $this->default;
                break;
            }
        }

        return $data;
    }
}